<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Status;
use App\Models\Jenis;
use Illuminate\Http\UploadedFile;

class ChapterAssignmentTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $author;
    private $reviewer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['user_role' => 'ADMIN']);
        $this->author = User::factory()->create(['user_role' => 'AUTHOR']);
        $this->reviewer = User::factory()->create(['user_role' => 'REVIEWER']);

        Status::create(['id' => Status::DRAFT, 'option' => 'Draft']);
        Status::create(['id' => Status::TERSEDIA, 'option' => 'Tersedia']);
        Status::create(['id' => Status::DITUGASKAN, 'option' => 'Ditugaskan']);
        Status::create(['id' => Status::DIKIRIM_AUTHOR, 'option' => 'Dikirim Author']);
        Status::create(['id' => Status::DALAM_REVIEW, 'option' => 'Dalam Review']);
        Status::create(['id' => Status::REVISI, 'option' => 'Revisi']);
        Status::create(['id' => Status::DIREVISI, 'option' => 'Direvisi']);
        Status::create(['id' => Status::DISETUJUI, 'option' => 'Disetujui']);
        Status::create(['id' => Status::FINALISASI, 'option' => 'Finalisasi']);
        Status::create(['id' => Status::TERBIT, 'option' => 'Terbit']);
    }

    public function test_admin_can_assign_author_and_reviewer()
    {
        $chapter = Bab::factory()->create([
            'author_id' => null,
            'reviewer_id' => null,
            'status_id' => Status::TERSEDIA,
        ]);

        $this->actingAs($this->admin)->put(route('admin.assign.chapter', $chapter->id), [
            'author_id' => $this->author->id,
            'reviewer_id' => $this->reviewer->id,
        ]);

        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'author_id' => $this->author->id,
            'reviewer_id' => $this->reviewer->id,
            'status_id' => Status::DITUGASKAN,
        ]);
    }

    public function test_admin_can_assign_author_only_without_reviewer()
    {
        $chapter = Bab::factory()->create([
            'author_id' => null,
            'reviewer_id' => null,
            'status_id' => Status::TERSEDIA,
        ]);

        $this->actingAs($this->admin)->put(route('admin.assign.chapter', $chapter->id), [
            'author_id' => $this->author->id,
        ]);

        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'author_id' => $this->author->id,
            'reviewer_id' => null,
            'status_id' => Status::DITUGASKAN,
        ]);
    }

    public function test_assign_fails_when_chapter_status_not_draft_or_tersedia()
    {
        $chapter = Bab::factory()->create([
            'author_id' => null,
            'reviewer_id' => null,
            'status_id' => Status::DISETUJUI,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.assign.chapter', $chapter->id), [
            'author_id' => $this->author->id,
            'reviewer_id' => $this->reviewer->id,
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('babs', [
            'id' => $chapter->id,
            'author_id' => $this->author->id,
        ]);
    }

    public function test_assign_fails_with_invalid_author_id()
    {
        $chapter = Bab::factory()->create([
            'author_id' => null,
            'reviewer_id' => null,
            'status_id' => Status::TERSEDIA,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.assign.chapter', $chapter->id), [
            'author_id' => 9999,
            'reviewer_id' => $this->reviewer->id,
        ]);

        $response->assertSessionHasErrors('author_id');
    }

    public function test_admin_can_store_chapters()
    {
        $buku = Buku::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('admin.store.chapter', $buku->id), [
            'bab' => ['Bab 1', 'Bab 2', 'Bab 3'],
        ]);

        $response->assertRedirect(route('admin.show.book', $buku->id));
        $this->assertDatabaseHas('babs', ['nama' => 'Bab 1', 'buku_id' => $buku->id, 'status_id' => Status::DRAFT]);
        $this->assertDatabaseHas('babs', ['nama' => 'Bab 2', 'buku_id' => $buku->id, 'status_id' => Status::DRAFT]);
        $this->assertDatabaseHas('babs', ['nama' => 'Bab 3', 'buku_id' => $buku->id, 'status_id' => Status::DRAFT]);
    }

    public function test_admin_can_approve_chapter()
    {
        $chapter = Bab::factory()->create([
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.approve.chapter', $chapter->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DISETUJUI,
        ]);
        $this->assertNotNull($chapter->fresh()->approved_at);
    }

    public function test_admin_cannot_approve_chapter_without_file()
    {
        $chapter = Bab::factory()->create([
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => null,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.approve.chapter', $chapter->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DISETUJUI,
        ]);
    }
}
