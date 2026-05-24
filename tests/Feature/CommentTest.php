<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_anonymous_comment()
    {
        // Set initial cache
        Cache::put('landing_comments', collect([]));

        $response = $this->post('/comments', [
            'message' => 'Ini komentar anonim dari testing.',
        ]);

        $response->assertRedirect();
        
        // Assert comment is created in database
        $this->assertDatabaseHas('comments', [
            'message' => 'Ini komentar anonim dari testing.',
        ]);

        // Assert cache was cleared (meaning it is now null/forgotten)
        $this->assertNull(Cache::get('landing_comments'));
    }

    public function test_comment_is_only_visible_on_landing_page()
    {
        $comment = Comment::create([
            'alias' => 'Anonymous#1111',
            'message' => 'Komentar Terlihat',
        ]);

        // Clear cache so it fetches fresh
        Cache::forget('landing_comments');

        // Get landing page
        $responseLanding = $this->get('/');
        $responseLanding->assertStatus(200);
        $responseLanding->assertSee('Komentar Terlihat');
        $responseLanding->assertSee('Anonymous#1111');

        // Get direktori page
        $responseDirektori = $this->get('/direktori-alumni');
        $responseDirektori->assertStatus(200);
        $responseDirektori->assertDontSee('Komentar Terlihat');
        $responseDirektori->assertDontSee('Anonymous#1111');
    }

    public function test_admin_can_manage_comments()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $comment = Comment::create([
            'alias' => 'Anonymous#2222',
            'message' => 'Komentar Spam',
        ]);

        // Get admin comments page
        $response = $this->actingAs($admin)->get('/admin/comments');
        $response->assertStatus(200);
        $response->assertSee('Komentar Spam');
        $response->assertSee('Anonymous#2222');

        // Delete comment
        $responseDelete = $this->actingAs($admin)->delete("/admin/comments/{$comment->id}");
        $responseDelete->assertRedirect();

        // Assert comment is deleted from database
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }
}
