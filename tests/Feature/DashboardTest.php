<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Bab;
use App\Models\Buku;
use App\Models\Status;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders()
    {
        $admin = User::factory()->create(['user_role' => 'ADMIN']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_author_dashboard_renders()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);

        $response = $this->actingAs($author)->get(route('author.dashboard'));
        $response->assertStatus(200);
    }

    public function test_reviewer_dashboard_renders()
    {
        $reviewer = User::factory()->create(['user_role' => 'REVIEWER']);

        $response = $this->actingAs($reviewer)->get(route('reviewer.dashboard'));
        $response->assertStatus(200);
    }

    public function test_dashboard_shows_recent_chapters_with_author_nama()
    {
        $author = User::factory()->create([
            'user_role' => 'AUTHOR',
            'username' => 'penulis123',
        ]);
        Status::create(['option' => 'approved']);
        $buku = Buku::factory()->create();

        $bab = Bab::create([
            'nama' => 'Bab Pengantar',
            'author_id' => $author->id,
            'buku_id' => $buku->id,
            'status_id' => 1,
        ]);

        $admin = User::factory()->create(['user_role' => 'ADMIN']);
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Bab Pengantar');
    }
}
