<?php

namespace Tests\Feature;

use App\Enums\AlumniStatus;
use App\Enums\UserRole;
use App\Models\Alumni;
use App\Models\Angkatan;
use App\Models\Forum;
use App\Models\ForumReply;
use App\Models\ForumThread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForumTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function makeVerifiedAlumni(): User
    {
        $user = User::factory()->create([
            'role'      => UserRole::ALUMNI->value,
            'is_active' => true,
        ]);

        $angkatan = Angkatan::create([
            'nama_angkatan' => 'Angkatan 2015',
            'tahun_ajaran'  => '2015',
            'status'        => 'LULUS',
        ]);

        Alumni::create([
            'user_id'            => $user->id,
            'nisn'               => '9999999999',
            'nama_lengkap'       => 'Alumni Forum Test',
            'angkatan_id'        => $angkatan->id,
            'jenis_kelamin'      => 'P',
            'status_verifikasi'  => AlumniStatus::VERIFIED->value,
            'is_profile_complete'=> true,
            'alamat'             => 'Jl. Test No. 1',
            'no_hp'              => '081234567890',
        ]);

        return $user;
    }

    private function makeAdmin(): User
    {
        return User::factory()->create(['role' => UserRole::ADMIN->value, 'is_active' => true]);
    }

    private function makeForum(): Forum
    {
        return Forum::create([
            'name'  => 'Diskusi Umum',
            'slug'  => 'diskusi-umum',
            'order' => 1,
        ]);
    }

    // -------------------------------------------------------------------------
    // Public Forum (Tanpa Login)
    // -------------------------------------------------------------------------

    public function test_public_can_view_forum_index(): void
    {
        $response = $this->get('/forum');
        $response->assertStatus(200);
    }

    public function test_public_can_view_forum_thread(): void
    {
        $admin  = $this->makeAdmin();
        $forum  = $this->makeForum();

        $thread = ForumThread::create([
            'forum_id' => $forum->id,
            'user_id'  => $admin->id,
            'title'    => 'Thread Publik',
            'body'     => 'Isi thread publik.',
        ]);

        $response = $this->get("/forum/thread/{$thread->slug}");
        $response->assertStatus(200);
        $response->assertSee('Thread Publik');
    }

    // -------------------------------------------------------------------------
    // Buat Thread (Butuh Login Alumni)
    // -------------------------------------------------------------------------

    public function test_authenticated_alumni_can_create_thread(): void
    {
        $alumniUser = $this->makeVerifiedAlumni();
        $forum      = $this->makeForum();

        $response = $this->actingAs($alumniUser)->post('/forum-thread', [
            'forum_id' => $forum->id,
            'title'    => 'Thread Baru dari Alumni',
            'body'     => 'Ini adalah isi thread baru yang dibuat oleh alumni.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('forum_threads', [
            'title'   => 'Thread Baru dari Alumni',
            'user_id' => $alumniUser->id,
        ]);
    }

    public function test_guest_cannot_create_thread(): void
    {
        $forum = $this->makeForum();

        $response = $this->post('/forum-thread', [
            'forum_id' => $forum->id,
            'title'    => 'Thread Tanpa Login',
            'body'     => 'Ini seharusnya gagal.',
        ]);

        // Diarahkan ke login / forum index atau error
        $response->assertRedirect();
        $this->assertDatabaseMissing('forum_threads', ['title' => 'Thread Tanpa Login']);
    }

    // -------------------------------------------------------------------------
    // Reply (Butuh Login Alumni)
    // -------------------------------------------------------------------------

    public function test_authenticated_alumni_can_reply_to_thread(): void
    {
        $alumniUser = $this->makeVerifiedAlumni();
        $admin      = $this->makeAdmin();
        $forum      = $this->makeForum();

        $thread = ForumThread::create([
            'forum_id' => $forum->id,
            'user_id'  => $admin->id,
            'title'    => 'Thread untuk Direply',
            'body'     => 'Isi thread.',
        ]);

        $response = $this->actingAs($alumniUser)->post("/forum-thread/{$thread->id}/reply", [
            'body' => 'Ini adalah balasan dari alumni.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('forum_replies', [
            'forum_thread_id' => $thread->id,
            'user_id'         => $alumniUser->id,
            'body'            => 'Ini adalah balasan dari alumni.',
        ]);
    }

    // -------------------------------------------------------------------------
    // Delete Thread
    // -------------------------------------------------------------------------

    public function test_alumni_can_delete_own_thread(): void
    {
        $alumniUser = $this->makeVerifiedAlumni();
        $forum      = $this->makeForum();

        $thread = ForumThread::create([
            'forum_id' => $forum->id,
            'user_id'  => $alumniUser->id,
            'title'    => 'Thread Milik Alumni',
            'body'     => 'Isi thread.',
        ]);

        $response = $this->actingAs($alumniUser)->delete("/forum-thread/{$thread->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('forum_threads', ['id' => $thread->id]);
    }

    public function test_alumni_cannot_delete_others_thread(): void
    {
        $alumniUser = $this->makeVerifiedAlumni();
        $admin      = $this->makeAdmin();
        $forum      = $this->makeForum();

        $thread = ForumThread::create([
            'forum_id' => $forum->id,
            'user_id'  => $admin->id,
            'title'    => 'Thread Milik Admin',
            'body'     => 'Isi thread admin.',
        ]);

        $response = $this->actingAs($alumniUser)->delete("/forum-thread/{$thread->id}");

        // Harus 403 atau gagal
        $response->assertStatus(403);
        $this->assertNotSoftDeleted('forum_threads', ['id' => $thread->id]);
    }

    // -------------------------------------------------------------------------
    // Admin Moderation
    // -------------------------------------------------------------------------

    public function test_admin_can_pin_thread(): void
    {
        $admin  = $this->makeAdmin();
        $forum  = $this->makeForum();

        $thread = ForumThread::create([
            'forum_id'  => $forum->id,
            'user_id'   => $admin->id,
            'title'     => 'Thread untuk Dipin',
            'body'       => 'Isi thread.',
            'is_pinned' => false,
        ]);

        $response = $this->actingAs($admin)->post("/admin/forum/thread/{$thread->id}/pin");

        $response->assertRedirect();
        $this->assertDatabaseHas('forum_threads', [
            'id'        => $thread->id,
            'is_pinned' => 1,
        ]);
    }

    public function test_admin_can_lock_thread(): void
    {
        $admin  = $this->makeAdmin();
        $forum  = $this->makeForum();

        $thread = ForumThread::create([
            'forum_id'  => $forum->id,
            'user_id'   => $admin->id,
            'title'     => 'Thread untuk Dikunci',
            'body'      => 'Isi thread.',
            'is_locked' => false,
        ]);

        $response = $this->actingAs($admin)->post("/admin/forum/thread/{$thread->id}/lock");

        $response->assertRedirect();
        $this->assertDatabaseHas('forum_threads', [
            'id'        => $thread->id,
            'is_locked' => 1,
        ]);
    }

    public function test_admin_can_delete_any_thread(): void
    {
        $admin      = $this->makeAdmin();
        $alumniUser = $this->makeVerifiedAlumni();
        $forum      = $this->makeForum();

        $thread = ForumThread::create([
            'forum_id' => $forum->id,
            'user_id'  => $alumniUser->id,
            'title'    => 'Thread Milik Alumni (Dihapus Admin)',
            'body'     => 'Isi thread alumni.',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/forum/thread/{$thread->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('forum_threads', ['id' => $thread->id]);
    }
}
