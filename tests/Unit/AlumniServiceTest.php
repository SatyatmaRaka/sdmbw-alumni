<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AlumniService;
use App\Services\CacheService;
use App\Models\Alumni;
use App\Models\User;
use App\Models\Angkatan;
use App\Models\AdminLog;
use App\Enums\AlumniStatus;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;
use Mockery;

class AlumniServiceTest extends TestCase
{
    use RefreshDatabase;

    private AlumniService $alumniService;
    private User $admin;
    private Angkatan $angkatan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->alumniService = $this->app->make(AlumniService::class);

        // Create standard admin for logging actions
        $this->admin = User::factory()->create([
            'role' => UserRole::ADMIN->value,
            'is_active' => true,
        ]);

        // Create standard angkatan
        $this->angkatan = Angkatan::factory()->lulus()->create();
    }

    /**
     * Helper to create alumni with user.
     */
    private function createAlumni(array $attributes = []): Alumni
    {
        $user = User::factory()->create([
            'role' => UserRole::ALUMNI->value,
            'is_active' => false,
        ]);

        return Alumni::factory()->create(array_merge([
            'user_id' => $user->id,
            'angkatan_id' => $this->angkatan->id,
            'status_verifikasi' => AlumniStatus::PENDING->value,
        ], $attributes));
    }

    // ==========================================
    // UPDATE ALUMNI TESTS (4 tests)
    // ==========================================

    public function test_update_alumni_success(): void
    {
        $alumni = $this->createAlumni(['nama_lengkap' => 'Old Name']);
        
        $updated = $this->alumniService->updateAlumni($alumni, [
            'nama_lengkap' => 'New Name',
        ], $this->admin->id);

        $this->assertEquals('New Name', $updated->nama_lengkap);
        $this->assertDatabaseHas('alumni', [
            'id' => $alumni->id,
            'nama_lengkap' => 'New Name',
        ]);
    }

    public function test_update_alumni_logs_correct_action(): void
    {
        $alumni = $this->createAlumni();
        
        $this->alumniService->updateAlumni($alumni, [
            'nama_lengkap' => 'Updated Name',
        ], $this->admin->id);

        $this->assertDatabaseHas('admin_logs', [
            'admin_id' => $this->admin->id,
            'action' => AdminLog::ACTION_UPDATE_ALUMNI,
            'target_type' => 'alumni',
            'target_id' => $alumni->id,
        ]);
    }

    public function test_update_alumni_clears_cache(): void
    {
        $alumni = $this->createAlumni();
        
        $cacheMock = Mockery::mock(CacheService::class);
        $cacheMock->shouldReceive('clearAllAlumniRelated')->once();
        
        $service = new AlumniService($cacheMock);
        $service->updateAlumni($alumni, ['nama_lengkap' => 'Name'], $this->admin->id);
    }

    public function test_update_alumni_rolls_back_on_exception(): void
    {
        $alumni = $this->createAlumni(['nama_lengkap' => 'Original Name']);
        
        try {
            $this->alumniService->updateAlumni($alumni, [
                'user_id' => 999999, // violates foreign key constraint
            ], $this->admin->id);
            $this->fail('QueryException was not thrown.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Exception expected
        }

        // Verify name remained original
        $this->assertDatabaseHas('alumni', [
            'id' => $alumni->id,
            'nama_lengkap' => 'Original Name',
        ]);
    }

    // ==========================================
    // VERIFY ALUMNI TESTS (5 tests)
    // ==========================================

    public function test_verify_alumni_to_verified_activates_user(): void
    {
        $alumni = $this->createAlumni();
        
        $message = $this->alumniService->verifyAlumni($alumni, AlumniStatus::VERIFIED->value, $this->admin->id);

        $this->assertStringContainsString('diverifikasi', $message);
        $this->assertEquals(AlumniStatus::VERIFIED->value, $alumni->fresh()->status_verifikasi);
        $this->assertTrue($alumni->fresh()->user->is_active);
    }

    public function test_verify_alumni_to_rejected_deactivates_user(): void
    {
        $alumni = $this->createAlumni(['status_verifikasi' => AlumniStatus::VERIFIED->value]);
        $alumni->user->update(['is_active' => true]);

        $message = $this->alumniService->verifyAlumni($alumni, AlumniStatus::REJECTED->value, $this->admin->id);

        $this->assertStringContainsString('ditolak', $message);
        $this->assertEquals(AlumniStatus::REJECTED->value, $alumni->fresh()->status_verifikasi);
        $this->assertFalse($alumni->fresh()->user->is_active);
    }

    public function test_verify_alumni_to_pending(): void
    {
        $alumni = $this->createAlumni(['status_verifikasi' => AlumniStatus::VERIFIED->value]);
        $alumni->user->update(['is_active' => true]);

        $message = $this->alumniService->verifyAlumni($alumni, AlumniStatus::PENDING->value, $this->admin->id);

        $this->assertStringContainsString('diperbarui', $message);
        $this->assertEquals(AlumniStatus::PENDING->value, $alumni->fresh()->status_verifikasi);
        $this->assertFalse($alumni->fresh()->user->is_active);
    }

    public function test_verify_alumni_logs_correct_action(): void
    {
        $alumni = $this->createAlumni();
        
        $this->alumniService->verifyAlumni($alumni, AlumniStatus::VERIFIED->value, $this->admin->id);

        $this->assertDatabaseHas('admin_logs', [
            'admin_id' => $this->admin->id,
            'action' => AdminLog::ACTION_VERIFY_ALUMNI,
            'target_id' => $alumni->id,
        ]);
    }

    public function test_verify_alumni_clears_cache(): void
    {
        $alumni = $this->createAlumni();
        
        $cacheMock = Mockery::mock(CacheService::class);
        $cacheMock->shouldReceive('clearAllAlumniRelated')->once();
        
        $service = new AlumniService($cacheMock);
        $service->verifyAlumni($alumni, AlumniStatus::VERIFIED->value, $this->admin->id);
    }

    // ==========================================
    // RESET PASSWORD TESTS (4 tests)
    // ==========================================

    public function test_reset_password_generates_12_character_password(): void
    {
        $alumni = $this->createAlumni();
        
        $password = $this->alumniService->resetPassword($alumni, $this->admin->id);

        $this->assertEquals(12, strlen($password));
        $this->assertTrue(Hash::check($password, $alumni->fresh()->user->password));
    }

    public function test_reset_password_marks_must_change_password_flag(): void
    {
        $alumni = $this->createAlumni();
        $alumni->user->update(['must_change_password' => false]);
        
        $this->alumniService->resetPassword($alumni, $this->admin->id);

        $this->assertTrue((bool)$alumni->fresh()->user->must_change_password);
    }

    public function test_reset_password_logs_correct_action(): void
    {
        $alumni = $this->createAlumni();
        
        $this->alumniService->resetPassword($alumni, $this->admin->id);

        $this->assertDatabaseHas('admin_logs', [
            'admin_id' => $this->admin->id,
            'action' => AdminLog::ACTION_RESET_PASSWORD,
            'target_id' => $alumni->id,
        ]);
    }

    public function test_reset_password_throws_exception_if_no_user(): void
    {
        $alumni = $this->createAlumni();
        $alumni->setRelation('user', null);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Akun user tidak ditemukan');

        $this->alumniService->resetPassword($alumni, $this->admin->id);
    }

    // ==========================================
    // RESET PASSWORD BY NISN TESTS (2 tests)
    // ==========================================

    public function test_reset_password_by_nisn_success(): void
    {
        $alumni = $this->createAlumni(['nisn' => '1122334455']);
        
        $updated = $this->alumniService->resetPasswordByNisn('1122334455', 'newpassword123', $this->admin->id);

        $this->assertEquals($alumni->id, $updated->id);
        $this->assertTrue(Hash::check('newpassword123', $alumni->fresh()->user->password));
        $this->assertTrue((bool)$alumni->fresh()->user->must_change_password);
        $this->assertDatabaseHas('admin_logs', [
            'admin_id' => $this->admin->id,
            'action' => AdminLog::ACTION_RESET_PASSWORD_NISN,
            'target_id' => $alumni->id,
        ]);
    }

    public function test_reset_password_by_nisn_throws_exception_if_not_found(): void
    {
        $this->expectException(Exception::class);

        $this->alumniService->resetPasswordByNisn('9999999999', 'password', $this->admin->id);
    }

    // ==========================================
    // DELETE ALUMNI TESTS (2 tests)
    // ==========================================

    public function test_delete_alumni_success(): void
    {
        $alumni = $this->createAlumni();
        $userId = $alumni->user_id;

        $this->alumniService->deleteAlumni($alumni, $this->admin->id);

        $this->assertDatabaseMissing('alumni', ['id' => $alumni->id]);
        $this->assertDatabaseMissing('users', ['id' => $userId]);
        $this->assertDatabaseHas('admin_logs', [
            'admin_id' => $this->admin->id,
            'action' => AdminLog::ACTION_DELETE_ALUMNI,
        ]);
    }

    // ==========================================
    // DELETE ALL ALUMNI TESTS (1 test)
    // ==========================================

    public function test_delete_all_alumni_success(): void
    {
        $this->createAlumni();
        $this->createAlumni();

        $this->alumniService->deleteAllAlumni($this->admin->id);

        $this->assertEquals(0, Alumni::count());
        $this->assertDatabaseHas('admin_logs', [
            'admin_id' => $this->admin->id,
            'action' => AdminLog::ACTION_DELETE_ALL_ALUMNI,
        ]);
    }
}
