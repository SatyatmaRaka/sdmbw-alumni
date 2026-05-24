<?php

namespace Tests\Feature;

use App\Enums\AlumniStatus;
use App\Enums\UserRole;
use App\Models\Alumni;
use App\Models\Angkatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniCrudTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function makeAdmin(): User
    {
        return User::factory()->create(['role' => UserRole::ADMIN->value, 'is_active' => true]);
    }

    private function makeAngkatan(): Angkatan
    {
        return Angkatan::create([
            'nama_angkatan' => 'Angkatan 2010',
            'tahun_ajaran'  => '2010',
            'status'        => 'LULUS',
        ]);
    }

    private function makeAlumniWithUser(Angkatan $angkatan, array $overrides = []): Alumni
    {
        $user = User::factory()->create([
            'role'      => UserRole::ALUMNI->value,
            'is_active' => false,
        ]);

        return Alumni::create(array_merge([
            'user_id'           => $user->id,
            'nisn'              => '1234567890',
            'nama_lengkap'      => 'Budi Santoso',
            'angkatan_id'       => $angkatan->id,
            'jenis_kelamin'     => 'L',
            'status_verifikasi' => AlumniStatus::PENDING->value,
        ], $overrides));
    }

    // -------------------------------------------------------------------------
    // Index / List
    // -------------------------------------------------------------------------

    public function test_admin_can_view_alumni_list(): void
    {
        $admin    = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();
        $this->makeAlumniWithUser($angkatan);

        $response = $this->actingAs($admin)->get('/admin/alumni');

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
    }

    public function test_admin_can_filter_alumni_by_status(): void
    {
        $admin    = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();

        $this->makeAlumniWithUser($angkatan, ['nama_lengkap' => 'Alumni Pending',  'nisn' => '1111111111', 'status_verifikasi' => AlumniStatus::PENDING->value]);
        $this->makeAlumniWithUser($angkatan, ['nama_lengkap' => 'Alumni Verified', 'nisn' => '2222222222', 'status_verifikasi' => AlumniStatus::VERIFIED->value]);

        $response = $this->actingAs($admin)->get('/admin/alumni?status=' . AlumniStatus::PENDING->value);

        $response->assertStatus(200);
        $response->assertSee('Alumni Pending');
        $response->assertDontSee('Alumni Verified');
    }

    // -------------------------------------------------------------------------
    // Show / Detail
    // -------------------------------------------------------------------------

    public function test_admin_can_view_alumni_detail(): void
    {
        $admin    = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();
        $alumni   = $this->makeAlumniWithUser($angkatan);

        $response = $this->actingAs($admin)->get("/admin/alumni/{$alumni->id}");

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
    }

    // -------------------------------------------------------------------------
    // Verify (Status Change)
    // -------------------------------------------------------------------------

    public function test_admin_can_verify_alumni(): void
    {
        $admin    = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();
        $alumni   = $this->makeAlumniWithUser($angkatan);

        $response = $this->actingAs($admin)->put("/admin/alumni/{$alumni->id}/verify", [
            'status' => AlumniStatus::VERIFIED->value,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('alumni', [
            'id'                => $alumni->id,
            'status_verifikasi' => AlumniStatus::VERIFIED->value,
        ]);

        // Pastikan akun user aktif setelah verifikasi
        $this->assertDatabaseHas('users', [
            'id'        => $alumni->user_id,
            'is_active' => 1,
        ]);
    }

    public function test_admin_can_reject_alumni(): void
    {
        $admin    = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();
        $alumni   = $this->makeAlumniWithUser($angkatan, ['status_verifikasi' => AlumniStatus::VERIFIED->value]);

        $response = $this->actingAs($admin)->put("/admin/alumni/{$alumni->id}/verify", [
            'status' => AlumniStatus::REJECTED->value,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('alumni', [
            'id'                => $alumni->id,
            'status_verifikasi' => AlumniStatus::REJECTED->value,
        ]);
    }

    public function test_verify_rejects_invalid_status(): void
    {
        $admin    = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();
        $alumni   = $this->makeAlumniWithUser($angkatan);

        $response = $this->actingAs($admin)->put("/admin/alumni/{$alumni->id}/verify", [
            'status' => 'invalid_status',
        ]);

        $response->assertSessionHasErrors('status');
    }

    // -------------------------------------------------------------------------
    // Delete
    // -------------------------------------------------------------------------

    public function test_admin_can_delete_alumni_permanently(): void
    {
        $admin    = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();
        $alumni   = $this->makeAlumniWithUser($angkatan);
        $userId   = $alumni->user_id;

        $response = $this->actingAs($admin)->delete("/admin/alumni/{$alumni->id}");

        $response->assertRedirect(route('admin.alumni.index'));
        $response->assertSessionHas('success');

        // Data alumni dan user terhapus permanen
        $this->assertDatabaseMissing('alumni', ['id' => $alumni->id]);
        $this->assertDatabaseMissing('users',  ['id' => $userId]);
    }

    // -------------------------------------------------------------------------
    // Reset Password
    // -------------------------------------------------------------------------

    public function test_admin_can_reset_alumni_password(): void
    {
        $admin    = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();
        $alumni   = $this->makeAlumniWithUser($angkatan);

        $response = $this->actingAs($admin)->post("/admin/alumni/{$alumni->id}/reset-password");

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertTrue(session()->has('new_password'));
    }

    // -------------------------------------------------------------------------
    // Access Control
    // -------------------------------------------------------------------------

    public function test_guest_cannot_access_admin_alumni(): void
    {
        $response = $this->get('/admin/alumni');
        $response->assertRedirect('/login');
    }

    public function test_alumni_user_cannot_access_admin_area(): void
    {
        $alumniUser = User::factory()->create([
            'role'      => UserRole::ALUMNI->value,
            'is_active' => true,
        ]);

        $response = $this->actingAs($alumniUser)->get('/admin/alumni');
        $response->assertStatus(403);
    }
}
