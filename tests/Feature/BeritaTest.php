<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BeritaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_add_berita_without_image()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/beritas', [
            'title' => 'Berita Tanpa Gambar',
            'content' => 'Ini konten berita tanpa gambar.',
            'is_active' => '1',
        ], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan!'
        ]);

        $this->assertDatabaseHas('berita', [
            'title' => 'Berita Tanpa Gambar',
        ]);
    }

    public function test_admin_can_add_berita_with_image()
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $image = UploadedFile::fake()->image('test_berita.jpg');

        $response = $this->actingAs($admin)->post('/admin/beritas', [
            'title' => 'Berita Bergambar',
            'content' => 'Ini konten berita bergambar.',
            'is_active' => '1',
            'image' => $image,
        ], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan!'
        ]);

        $this->assertDatabaseHas('berita', [
            'title' => 'Berita Bergambar',
        ]);

        // Get the created berita to check image path
        $berita = Berita::where('title', 'Berita Bergambar')->first();
        $this->assertNotNull($berita->image);
        Storage::disk('public')->assertExists($berita->image);
    }

    public function test_admin_can_edit_berita()
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $berita = Berita::create([
            'title' => 'Berita Lama',
            'content' => 'Konten berita lama.',
            'is_active' => true,
        ]);

        $newImage = UploadedFile::fake()->image('new_berita.png');

        // Using POST with _method = PUT (method spoofing)
        $response = $this->actingAs($admin)->post("/admin/beritas/{$berita->id}", [
            '_method' => 'PUT',
            'title' => 'Berita Baru',
            'content' => 'Konten berita baru.',
            'is_active' => '0',
            'image' => $newImage,
        ], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Berita berhasil diperbarui!'
        ]);

        $this->assertDatabaseHas('berita', [
            'id' => $berita->id,
            'title' => 'Berita Baru',
            'content' => 'Konten berita baru.',
            'is_active' => 0,
        ]);

        $berita->refresh();
        $this->assertNotNull($berita->image);
        Storage::disk('public')->assertExists($berita->image);
    }

    public function test_public_can_view_berita_index()
    {
        Berita::create([
            'title' => 'Berita Publik Aktif',
            'content' => 'Konten berita publik.',
            'is_active' => true,
        ]);

        Berita::create([
            'title' => 'Berita Publik Nonaktif',
            'content' => 'Konten berita nonaktif.',
            'is_active' => false,
        ]);

        $response = $this->get('/berita');

        $response->assertStatus(200);
        $response->assertSee('Berita Publik Aktif');
        $response->assertDontSee('Berita Publik Nonaktif');
    }

    public function test_public_can_view_berita_detail_and_increments_views()
    {
        $berita = Berita::create([
            'title' => 'Berita Detail',
            'content' => '<p>Konten detail lengkap.</p>',
            'is_active' => true,
            'views_count' => 5,
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
        $response->assertSee('Berita Detail');
        $response->assertSee('5'); // old views count formatted/shown in context before increment or after increment

        $berita->refresh();
        $this->assertEquals(6, $berita->views_count);
    }

    public function test_public_cannot_view_inactive_berita_detail()
    {
        $berita = Berita::create([
            'title' => 'Berita Inaktif',
            'content' => 'Konten inaktif.',
            'is_active' => false,
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(404);
    }

    public function test_admin_can_toggle_featured_berita()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $berita = Berita::create([
            'title' => 'Berita Unggulan',
            'content' => 'Konten berita.',
            'is_active' => true,
            'is_featured' => false,
        ]);

        $response = $this->actingAs($admin)->post("/admin/beritas/{$berita->id}/toggle-featured", [], [
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_featured' => true,
        ]);

        $berita->refresh();
        $this->assertTrue($berita->is_featured);
    }

    public function test_auto_excerpt_generation()
    {
        $berita = Berita::create([
            'title' => 'Berita Tanpa Excerpt',
            'content' => '<strong>Ini konten dengan HTML tags</strong> yang sangat panjang dan harus digenerate excerptnya secara otomatis.',
            'is_active' => true,
        ]);

        $this->assertNotNull($berita->excerpt);
        $this->assertStringContainsString('Ini konten dengan HTML tags', $berita->excerpt);
        $this->assertStringNotContainsString('<strong>', $berita->excerpt);
    }
}
