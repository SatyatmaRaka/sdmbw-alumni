<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Angkatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AngkatanCrudTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_admin_can_view_angkatan_index(): void
    {
        $admin = $this->makeAdmin();
        $this->makeAngkatan();

        $response = $this->actingAs($admin)->get('/admin/angkatan?search=Angkatan+2010');

        $response->assertStatus(200);
        $response->assertSee('Angkatan 2010');
    }

    public function test_admin_can_create_angkatan(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post('/admin/angkatan', [
            'nama_angkatan' => 'Angkatan Baru',
            'tahun_ajaran'  => '2024',
            'status'        => 'AKTIF',
        ]);

        $response->assertRedirect(route('admin.angkatan.index'));
        $this->assertDatabaseHas('angkatan', [
            'nama_angkatan' => 'Angkatan Baru',
            'tahun_ajaran'  => '2024',
            'status'        => 'AKTIF',
        ]);
    }

    public function test_admin_can_edit_angkatan(): void
    {
        $admin = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();

        $response = $this->actingAs($admin)->put("/admin/angkatan/{$angkatan->id}", [
            'nama_angkatan' => 'Angkatan Update',
            'tahun_ajaran'  => '2011',
            'status'        => 'LULUS',
        ]);

        $response->assertRedirect(route('admin.angkatan.index'));
        $this->assertDatabaseHas('angkatan', [
            'id' => $angkatan->id,
            'nama_angkatan' => 'Angkatan Update',
            'tahun_ajaran'  => '2011',
            'status'        => 'LULUS',
        ]);
    }

    public function test_admin_can_delete_angkatan(): void
    {
        $admin = $this->makeAdmin();
        $angkatan = $this->makeAngkatan();

        $response = $this->actingAs($admin)->delete("/admin/angkatan/{$angkatan->id}");

        $response->assertRedirect(route('admin.angkatan.index'));
        $this->assertDatabaseMissing('angkatan', ['id' => $angkatan->id]);
    }

    public function test_guest_cannot_access_angkatan_management(): void
    {
        $response = $this->get('/admin/angkatan');
        $response->assertRedirect('/login');
    }

    public function test_alumni_cannot_access_angkatan_management(): void
    {
        $alumniUser = User::factory()->create([
            'role'      => UserRole::ALUMNI->value,
            'is_active' => true,
        ]);

        $response = $this->actingAs($alumniUser)->get('/admin/angkatan');
        $response->assertStatus(403);
    }
}
