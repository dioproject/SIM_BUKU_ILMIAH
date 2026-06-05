<?php

namespace Tests\Feature;

use App\Models\Bab;
use App\Models\Buku;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['Pending', 'Available', 'Approve', 'Claimed'] as $option) {
            Status::create(['option' => $option]);
        }
    }

    public function test_author_chapter_index_only_shows_owned_or_available_chapters()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $otherAuthor = User::factory()->create(['user_role' => 'AUTHOR']);
        $buku = Buku::factory()->create();

        Bab::factory()->create([
            'nama' => 'Bab Milik Saya',
            'author_id' => $author->id,
            'buku_id' => $buku->id,
            'status_id' => 4,
        ]);

        Bab::factory()->create([
            'nama' => 'Bab Masih Tersedia',
            'author_id' => null,
            'buku_id' => $buku->id,
            'status_id' => 2,
        ]);

        Bab::factory()->create([
            'nama' => 'Bab Milik Orang Lain',
            'author_id' => $otherAuthor->id,
            'buku_id' => $buku->id,
            'status_id' => 4,
        ]);

        $response = $this->actingAs($author)->get(route('author.index.chapter'));

        $response->assertStatus(200);
        $response->assertSee('Bab Milik Saya');
        $response->assertSee('Bab Masih Tersedia');
        $response->assertDontSee('Bab Milik Orang Lain');
    }

    public function test_author_cannot_claim_chapter_that_is_already_claimed()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $otherAuthor = User::factory()->create(['user_role' => 'AUTHOR']);
        $chapter = Bab::factory()->create([
            'author_id' => $otherAuthor->id,
            'status_id' => 4,
        ]);

        $this->actingAs($author)->put(route('author.claimed.chapter', $chapter->id));

        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'author_id' => $otherAuthor->id,
            'status_id' => 4,
        ]);
    }

    public function test_author_cannot_upload_chapter_owned_by_another_author()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $otherAuthor = User::factory()->create(['user_role' => 'AUTHOR']);
        $chapter = Bab::factory()->create([
            'author_id' => $otherAuthor->id,
            'status_id' => 4,
            'file_bab' => null,
        ]);

        $this->actingAs($author)->put(route('author.upload.chapter', $chapter->id), [
            'file_bab' => \Illuminate\Http\UploadedFile::fake()->create('bab.docx', 12),
        ]);

        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'file_bab' => null,
        ]);
    }

    public function test_reviewer_cannot_approve_chapter_without_review_file()
    {
        $reviewer = User::factory()->create(['user_role' => 'REVIEWER']);
        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $chapter = Bab::factory()->create([
            'author_id' => $author->id,
            'status_id' => 4,
            'file_bab' => 'bab.docx',
            'file_revieu' => null,
        ]);

        $this->actingAs($reviewer)->put(route('reviewer.approve.chapter', $chapter->id));

        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'status_id' => 4,
            'approved_at' => null,
        ]);
    }
}
