<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Status;
use Illuminate\Http\UploadedFile;

class AuthorWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private $author;
    private $otherAuthor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->author = User::factory()->create(['user_role' => 'AUTHOR']);
        $this->otherAuthor = User::factory()->create(['user_role' => 'AUTHOR']);

        Status::create(['id' => Status::DRAFT, 'option' => 'Draft']);
        Status::create(['id' => Status::TERSEDIA, 'option' => 'Tersedia']);
        Status::create(['id' => Status::DITUGASKAN, 'option' => 'Ditugaskan']);
        Status::create(['id' => Status::DIKIRIM_AUTHOR, 'option' => 'Dikirim Author']);
        Status::create(['id' => Status::DALAM_REVIEW, 'option' => 'Dalam Review']);
        Status::create(['id' => Status::REVISI, 'option' => 'Revisi']);
        Status::create(['id' => Status::DIREVISI, 'option' => 'Direvisi']);
        Status::create(['id' => Status::DISETUJUI, 'option' => 'Disetujui']);
    }

    public function test_author_chapter_index_only_shows_assigned_chapters()
    {
        $buku = Buku::factory()->create();

        Bab::factory()->create([
            'nama' => 'Bab Milik Saya',
            'author_id' => $this->author->id,
            'buku_id' => $buku->id,
            'status_id' => Status::DITUGASKAN,
        ]);

        Bab::factory()->create([
            'nama' => 'Bab Belum Ditugaskan',
            'author_id' => null,
            'buku_id' => $buku->id,
            'status_id' => Status::TERSEDIA,
        ]);

        Bab::factory()->create([
            'nama' => 'Bab Milik Orang Lain',
            'author_id' => $this->otherAuthor->id,
            'buku_id' => $buku->id,
            'status_id' => Status::DITUGASKAN,
        ]);

        $response = $this->actingAs($this->author)->get(route('author.index.chapter'));

        $response->assertStatus(200);
        $response->assertSee('Bab Milik Saya');
        $response->assertDontSee('Bab Belum Ditugaskan');
        $response->assertDontSee('Bab Milik Orang Lain');
    }

    public function test_author_books_index_only_shows_books_with_assigned_chapters()
    {
        $bukuDenganTugas = Buku::factory()->create(['judul' => 'Buku Saya']);
        $bukuTanpaTugas = Buku::factory()->create(['judul' => 'Buku Orang Lain']);

        Bab::factory()->create([
            'author_id' => $this->author->id,
            'buku_id' => $bukuDenganTugas->id,
            'status_id' => Status::DITUGASKAN,
        ]);

        Bab::factory()->create([
            'author_id' => $this->otherAuthor->id,
            'buku_id' => $bukuTanpaTugas->id,
            'status_id' => Status::DITUGASKAN,
        ]);

        $response = $this->actingAs($this->author)->get(route('author.index.book'));

        $response->assertStatus(200);
        $response->assertSee('Buku Saya');
        $response->assertDontSee('Buku Orang Lain');
    }

    public function test_author_can_upload_chapter()
    {
        $chapter = Bab::factory()->create([
            'author_id' => $this->author->id,
            'reviewer_id' => null,
            'status_id' => Status::DITUGASKAN,
            'file_bab' => null,
        ]);

        $file = UploadedFile::fake()->create('bab.docx', 12);

        $response = $this->actingAs($this->author)->put(route('author.upload.chapter', $chapter->id), [
            'file_bab' => $file,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
        ]);
        $this->assertNotNull($chapter->fresh()->file_bab);
        $this->assertNotNull($chapter->fresh()->uploaded_at);
    }

    public function test_author_can_upload_revision_when_status_is_revisi()
    {
        $chapter = Bab::factory()->create([
            'author_id' => $this->author->id,
            'status_id' => Status::REVISI,
            'file_bab' => 'old_bab.docx',
        ]);

        $file = UploadedFile::fake()->create('bab_revisi.docx', 12);

        $response = $this->actingAs($this->author)->put(route('author.upload.chapter', $chapter->id), [
            'file_bab' => $file,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DIREVISI,
        ]);
    }

    public function test_author_cannot_upload_chapter_owned_by_another_author()
    {
        $chapter = Bab::factory()->create([
            'author_id' => $this->otherAuthor->id,
            'status_id' => Status::DITUGASKAN,
            'file_bab' => null,
        ]);

        $file = UploadedFile::fake()->create('bab.docx', 12);

        $this->actingAs($this->author)->put(route('author.upload.chapter', $chapter->id), [
            'file_bab' => $file,
        ]);

        $this->assertDatabaseHas('babs', [
            'id' => $chapter->id,
            'file_bab' => null,
        ]);
    }

    public function test_author_cannot_upload_chapter_with_wrong_status()
    {
        $chapter = Bab::factory()->create([
            'author_id' => $this->author->id,
            'status_id' => Status::DISETUJUI,
            'file_bab' => 'existing.docx',
        ]);

        $file = UploadedFile::fake()->create('new.docx', 12);

        $this->actingAs($this->author)->put(route('author.upload.chapter', $chapter->id), [
            'file_bab' => $file,
        ]);

        $this->assertDatabaseMissing('babs', [
            'id' => $chapter->id,
            'status_id' => Status::DIKIRIM_AUTHOR,
        ]);
    }

    public function test_author_show_book_only_shows_their_chapters()
    {
        $buku = Buku::factory()->create();

        Bab::factory()->create([
            'nama' => 'Bab Saya',
            'author_id' => $this->author->id,
            'buku_id' => $buku->id,
            'status_id' => Status::DITUGASKAN,
        ]);

        Bab::factory()->create([
            'nama' => 'Bab Rahasia',
            'author_id' => $this->otherAuthor->id,
            'buku_id' => $buku->id,
            'status_id' => Status::DITUGASKAN,
        ]);

        $response = $this->actingAs($this->author)->get(route('author.show.book', $buku->id));

        $response->assertStatus(200);
        $response->assertSee('Bab Saya');
        $response->assertDontSee('Bab Rahasia');
    }

    public function test_author_cannot_access_admin_routes()
    {
        $response = $this->actingAs($this->author)->get(route('admin.index.book'));
        $response->assertStatus(403);
    }
}
