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
        $buku = Buku::factory()->create();

        $bab = Bab::factory()->create([
            'nama' => 'Bab Pengantar',
            'author_id' => $author->id,
            'buku_id' => $buku->id,
        ]);

        $admin = User::factory()->create(['user_role' => 'ADMIN']);
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Bab Pengantar');
    }

    public function test_admin_dashboard_shows_total_books()
    {
        $admin = User::factory()->create(['user_role' => 'ADMIN']);
        Buku::factory()->count(3)->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Total Buku');
        $response->assertSee('3');
    }

    public function test_admin_dashboard_shows_total_authors()
    {
        $admin = User::factory()->create(['user_role' => 'ADMIN']);
        User::factory()->count(2)->create(['user_role' => 'AUTHOR']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Total Penulis');
    }

    public function test_admin_dashboard_shows_total_reviewers()
    {
        $admin = User::factory()->create(['user_role' => 'ADMIN']);
        User::factory()->count(2)->create(['user_role' => 'REVIEWER']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Total Reviewer');
    }

    public function test_admin_dashboard_shows_chapters_by_status()
    {
        Status::create(['id' => Status::DRAFT, 'option' => 'Draft']);
        Status::create(['id' => Status::DISETUJUI, 'option' => 'Disetujui']);

        $admin = User::factory()->create(['user_role' => 'ADMIN']);
        Bab::factory()->count(2)->create(['status_id' => Status::DRAFT]);
        Bab::factory()->count(3)->create(['status_id' => Status::DISETUJUI]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Status Bab');
    }

    public function test_author_dashboard_shows_assigned_chapters()
    {
        Status::create(['id' => Status::DITUGASKAN, 'option' => 'Ditugaskan']);
        Status::create(['id' => Status::REVISI, 'option' => 'Revisi']);

        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $buku = Buku::factory()->create();

        Bab::factory()->count(2)->create([
            'author_id' => $author->id,
            'buku_id' => $buku->id,
            'status_id' => Status::DITUGASKAN,
        ]);
        Bab::factory()->create([
            'author_id' => $author->id,
            'buku_id' => $buku->id,
            'status_id' => Status::REVISI,
        ]);

        $response = $this->actingAs($author)->get(route('author.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Bab Ditugaskan');
        $response->assertSee('Perlu Revisi');
    }

    public function test_reviewer_dashboard_shows_assigned_chapters()
    {
        Status::create(['id' => Status::DIKIRIM_AUTHOR, 'option' => 'Dikirim Author']);
        Status::create(['id' => Status::DALAM_REVIEW, 'option' => 'Dalam Review']);

        $reviewer = User::factory()->create(['user_role' => 'REVIEWER']);
        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $buku = Buku::factory()->create();

        Bab::factory()->count(2)->create([
            'reviewer_id' => $reviewer->id,
            'author_id' => $author->id,
            'buku_id' => $buku->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
        ]);
        Bab::factory()->create([
            'reviewer_id' => $reviewer->id,
            'author_id' => $author->id,
            'buku_id' => $buku->id,
            'status_id' => Status::DALAM_REVIEW,
        ]);

        $response = $this->actingAs($reviewer)->get(route('reviewer.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Perlu Direview');
        $response->assertSee('Sedang Direview');
    }
}
