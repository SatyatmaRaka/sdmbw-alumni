<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\Alumni;
use App\Models\Angkatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KepalaSekolahTest extends TestCase
{
    use RefreshDatabase;

    private function makeKepalaSekolah(): User
    {
        return User::factory()->create(['role' => UserRole::KEPALA_SEKOLAH->value, 'is_active' => true]);
    }

    public function test_kepala_sekolah_can_view_dashboard(): void
    {
        $ks = $this->makeKepalaSekolah();

        $response = $this->actingAs($ks)->get('/kepala-sekolah/dashboard');

        $response->assertStatus(200);
    }

    public function test_kepala_sekolah_can_view_alumni_list(): void
    {
        $ks = $this->makeKepalaSekolah();

        $response = $this->actingAs($ks)->get('/admin/alumni');

        $response->assertStatus(200);
    }

    public function test_kepala_sekolah_can_view_alumni_detail(): void
    {
        $ks = $this->makeKepalaSekolah();
        
        $angkatan = Angkatan::create([
            'nama_angkatan' => 'Angkatan 2010',
            'tahun_ajaran'  => '2010',
            'status'        => 'LULUS',
        ]);

        $alumniUser = User::factory()->create(['role' => UserRole::ALUMNI->value]);
        $alumni = Alumni::create([
            'user_id' => $alumniUser->id,
            'angkatan_id' => $angkatan->id,
            'nisn' => '12345',
            'nama_lengkap' => 'Alumni A',
            'tahun_lulus' => 2010,
            'jenis_kelamin' => 'L',
        ]);

        $response = $this->actingAs($ks)->get("/admin/alumni/{$alumni->id}");

        $response->assertStatus(200);
        $response->assertSee('Alumni A');
    }

    public function test_kepala_sekolah_can_view_laporan_index(): void
    {
        $ks = $this->makeKepalaSekolah();

        $response = $this->actingAs($ks)->get('/admin/laporan');

        $response->assertStatus(200);
    }

    public function test_kepala_sekolah_cannot_access_admin_only_routes(): void
    {
        $ks = $this->makeKepalaSekolah();

        // admin angkatan index should be 403
        $response = $this->actingAs($ks)->get('/admin/angkatan');
        $response->assertStatus(403);
    }

    public function test_kepala_sekolah_cannot_access_user_management(): void
    {
        $ks = $this->makeKepalaSekolah();

        $response = $this->actingAs($ks)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_kepala_sekolah_dashboard(): void
    {
        $response = $this->get('/kepala-sekolah/dashboard');
        $response->assertRedirect('/login');
    }
}
