<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Status;
use Illuminate\Http\UploadedFile;

class ReviewerWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private $reviewer;
    private $otherReviewer;
    private $author;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reviewer = User::factory()->create(['user_role' => 'REVIEWER']);
        $this->otherReviewer = User::factory()->create(['user_role' => 'REVIEWER']);
        $this->author = User::factory()->create(['user_role' => 'AUTHOR']);

        Status::create(['id' => Status::DRAFT, 'option' => 'Draft']);
        Status::create(['id' => Status::TERSEDIA, 'option' => 'Tersedia']);
        Status::create(['id' => Status::DITUGASKAN, 'option' => 'Ditugaskan']);
        Status::create(['id' => Status::DIKIRIM_AUTHOR, 'option' => 'Dikirim Author']);
        Status::create(['id' => Status::DALAM_REVIEW, 'option' => 'Dalam Review']);
        Status::create(['id' => Status::REVISI, 'option' => 'Revisi']);
        Status::create(['id' => Status::DIREVISI, 'option' => 'Direvisi']);
        Status::create(['id' => Status::DISETUJUI, 'option' => 'Disetujui']);
    }

    public function test_reviewer_chapter_index_only_shows_assigned_chapters()
    {
        $buku = Buku::factory()->create();

        Bab::factory()->create([
            'nama' => 'Review Saya',
            'reviewer_id' => $this->reviewer->id,
            'author_id' => $this->author->id,
            'buku_id' => $buku->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
            'file_bab' => 'bab.docx',
        ]);

        Bab::factory()->create([
            'nama' => 'Review Orang Lain',
            'reviewer_id' => $this->otherReviewer->id,
            'author_id' => $this->author->id,
            'buku_id' => $buku->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
            'file_bab' => 'bab.docx',
        ]);

        $response = $this->actingAs($this->reviewer)->get(route('reviewer.index.chapter'));

        $response->assertStatus(200);
        $response->assertSee('Review Saya');
        $response->assertDontSee('Review Orang Lain');
    }

    public function test_reviewer_books_index_only_shows_books_with_assigned_chapters()
    {
        $bukuSaya = Buku::factory()->create(['judul' => 'Buku Saya Review']);
        $bukuLain = Buku::factory()->create(['judul' => 'Buku Lain']);

        Bab::factory()->create([
            'reviewer_id' => $this->reviewer->id,
            'author_id' => $this->author->id,
            'buku_id' => $bukuSaya->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
            'file_bab' => 'bab.docx',
        ]);

        Bab::factory()->create([
            'reviewer_id' => $this->otherReviewer->id,
            'author_id' => $this->author->id,
            'buku_id' => $bukuLain->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
            'file_bab' => 'bab.docx',
        ]);

        $response = $this->actingAs($this->reviewer)->get(route('reviewer.index.book'));

        $response->assertStatus(200);
        $response->assertSee('Buku Saya Review');
        $response->assertDontSee('Buku Lain');
    }

    public function test_reviewer_can_upload_review_file()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->reviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
            'file_bab' => 'bab.docx',
            'file_revieu' => null,
        ]);

        $file = UploadedFile::fake()->create('review.docx', 12);

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.upload.review', $chapter->id), [
            'file_revieu' => $file,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DALAM_REVIEW,
        ]);
        $this->assertNotNull($chapter->fresh()->file_revieu);
    }

    public function test_reviewer_cannot_upload_review_for_unassigned_chapter()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->otherReviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
            'file_bab' => 'bab.docx',
            'file_revieu' => null,
        ]);

        $file = UploadedFile::fake()->create('review.docx', 12);

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.upload.review', $chapter->id), [
            'file_revieu' => $file,
        ]);

        $response->assertSessionHas('error');
        $this->assertNull($chapter->fresh()->file_revieu);
    }

    public function test_reviewer_cannot_upload_review_for_chapter_without_author_file()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->reviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
            'file_bab' => null,
            'file_revieu' => null,
        ]);

        $file = UploadedFile::fake()->create('review.docx', 12);

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.upload.review', $chapter->id), [
            'file_revieu' => $file,
        ]);

        $response->assertSessionHas('error');
        $this->assertNull($chapter->fresh()->file_revieu);
    }

    public function test_reviewer_can_approve_chapter_with_review_file()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->reviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
            'file_revieu' => 'review.docx',
        ]);

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.approve.chapter', $chapter->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DISETUJUI,
        ]);
    }

    public function test_reviewer_can_approve_chapter_with_notes_only()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->reviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
            'file_revieu' => null,
            'catatan' => 'Sudah baik, lanjutkan',
        ]);

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.approve.chapter', $chapter->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DISETUJUI,
        ]);
    }

    public function test_reviewer_cannot_approve_without_review_file_or_notes()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->reviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
            'file_revieu' => null,
            'catatan' => null,
        ]);

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.approve.chapter', $chapter->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DISETUJUI,
        ]);
    }

    public function test_reviewer_can_request_revision()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->reviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
            'file_revieu' => 'review.docx',
        ]);

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.revisi.chapter', $chapter->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'status_id' => Status::REVISI,
        ]);
    }

    public function test_reviewer_cannot_request_revision_without_review_file_or_notes()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->reviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
            'file_revieu' => null,
            'catatan' => null,
        ]);

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.revisi.chapter', $chapter->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('babs', [
            'id' => $chapter->id,
            'status_id' => Status::REVISI,
        ]);
    }

    public function test_reviewer_cannot_approve_chapter_not_assigned_to_them()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->otherReviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
            'file_revieu' => 'review.docx',
        ]);

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.approve.chapter', $chapter->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DISETUJUI,
        ]);
    }

    public function test_reviewer_cannot_upload_note_for_unassigned_chapter()
    {
        $chapter = Bab::factory()->create([
            'reviewer_id' => $this->otherReviewer->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
        ]);

        $this->actingAs($this->reviewer)->put(route('reviewer.notes.review', $chapter->id), [
            'catatan' => 'Catatan rahasia',
        ]);

        $this->assertDatabaseMissing('babs', [
            'id' => $chapter->id,
            'catatan' => 'Catatan rahasia',
        ]);
    }

    public function test_reviewer_cannot_access_admin_routes()
    {
        $response = $this->actingAs($this->reviewer)->get(route('admin.index.book'));
        $response->assertStatus(403);
    }
}
