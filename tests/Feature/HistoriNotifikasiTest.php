<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Status;
use App\Models\Histori;
use App\Models\Notifikasi;
use Illuminate\Http\UploadedFile;

class HistoriNotifikasiTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $author;
    private $reviewer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['user_role' => 'ADMIN', 'username' => 'admin_utama']);
        $this->author = User::factory()->create(['user_role' => 'AUTHOR', 'username' => 'penulis_buku']);
        $this->reviewer = User::factory()->create(['user_role' => 'REVIEWER', 'username' => 'reviewer_teks']);

        Status::create(['id' => Status::DRAFT, 'option' => 'Draft']);
        Status::create(['id' => Status::TERSEDIA, 'option' => 'Tersedia']);
        Status::create(['id' => Status::DITUGASKAN, 'option' => 'Ditugaskan']);
        Status::create(['id' => Status::DIKIRIM_AUTHOR, 'option' => 'Dikirim Author']);
        Status::create(['id' => Status::DALAM_REVIEW, 'option' => 'Dalam Review']);
        Status::create(['id' => Status::REVISI, 'option' => 'Revisi']);
        Status::create(['id' => Status::DIREVISI, 'option' => 'Direvisi']);
        Status::create(['id' => Status::DISETUJUI, 'option' => 'Disetujui']);
    }

    public function test_create_user_creates_history()
    {
        $this->actingAs($this->admin)->post(route('admin.store.user'), [
            'username' => 'newuser',
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'contact' => '081234567890',
            'phone_region' => '+62',
            'user_role' => 'AUTHOR',
        ]);

        $this->assertDatabaseHas('historis', [
            'detail' => 'admin_utama added user newuser',
        ]);
    }

    public function test_delete_user_creates_history()
    {
        $user = User::factory()->create(['user_role' => 'AUTHOR', 'username' => 'user_dihapus']);

        $this->actingAs($this->admin)->delete(route('admin.destroy.user', $user->id));

        $this->assertDatabaseHas('historis', [
            'detail' => 'admin_utama deleted user user_dihapus',
        ]);
    }

    public function test_assign_chapter_creates_history()
    {
        $buku = Buku::factory()->create(['judul' => 'Buku Sejarah']);
        $chapter = Bab::factory()->create([
            'nama' => 'Bab 1',
            'buku_id' => $buku->id,
            'author_id' => null,
            'reviewer_id' => null,
            'status_id' => Status::TERSEDIA,
        ]);

        $this->actingAs($this->admin)->put(route('admin.assign.chapter', $chapter->id), [
            'author_id' => $this->author->id,
            'reviewer_id' => $this->reviewer->id,
        ]);

        $this->assertDatabaseHas('historis', [
            'bab_id' => $chapter->id,
            'status_id' => Status::DITUGASKAN,
            'action' => 'assign',
        ]);
    }

    public function test_assign_chapter_creates_notification_for_author()
    {
        $buku = Buku::factory()->create(['judul' => 'Buku Novel']);
        $chapter = Bab::factory()->create([
            'nama' => 'Bab Awal',
            'buku_id' => $buku->id,
            'author_id' => null,
            'reviewer_id' => null,
            'status_id' => Status::TERSEDIA,
        ]);

        $this->actingAs($this->admin)->put(route('admin.assign.chapter', $chapter->id), [
            'author_id' => $this->author->id,
            'reviewer_id' => $this->reviewer->id,
        ]);

        $this->assertDatabaseHas('notifikasis', [
            'user_id' => $this->author->id,
            'bab_id' => $chapter->id,
        ]);
    }

    public function test_assign_chapter_creates_notification_for_reviewer()
    {
        $buku = Buku::factory()->create(['judul' => 'Buku Sains']);
        $chapter = Bab::factory()->create([
            'nama' => 'Bab Sains',
            'buku_id' => $buku->id,
            'author_id' => null,
            'reviewer_id' => null,
            'status_id' => Status::TERSEDIA,
        ]);

        $this->actingAs($this->admin)->put(route('admin.assign.chapter', $chapter->id), [
            'author_id' => $this->author->id,
            'reviewer_id' => $this->reviewer->id,
        ]);

        $this->assertDatabaseHas('notifikasis', [
            'user_id' => $this->reviewer->id,
            'bab_id' => $chapter->id,
        ]);
    }

    public function test_author_upload_creates_history()
    {
        $buku = Buku::factory()->create(['judul' => 'Buku Saya']);
        $chapter = Bab::factory()->create([
            'nama' => 'Bab Satu',
            'buku_id' => $buku->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DITUGASKAN,
            'file_bab' => null,
        ]);

        $file = UploadedFile::fake()->create('bab_satu.docx', 12);
        $this->actingAs($this->author)->put(route('author.upload.chapter', $chapter->id), [
            'file_bab' => $file,
        ]);

        $this->assertDatabaseHas('historis', [
            'bab_id' => $chapter->id,
            'action' => 'upload',
        ]);
    }

    public function test_author_upload_creates_notification_for_admin()
    {
        $buku = Buku::factory()->create(['judul' => 'Buku Upload']);
        $chapter = Bab::factory()->create([
            'nama' => 'Bab Upload',
            'buku_id' => $buku->id,
            'author_id' => $this->author->id,
            'status_id' => Status::DITUGASKAN,
            'file_bab' => null,
        ]);

        $file = UploadedFile::fake()->create('bab_upload.docx', 12);
        $this->actingAs($this->author)->put(route('author.upload.chapter', $chapter->id), [
            'file_bab' => $file,
        ]);

        $this->assertDatabaseHas('notifikasis', [
            'user_id' => $this->admin->id,
            'bab_id' => $chapter->id,
        ]);
    }

    public function test_reviewer_approve_creates_history()
    {
        $chapter = Bab::factory()->create([
            'nama' => 'Bab Final',
            'author_id' => $this->author->id,
            'reviewer_id' => $this->reviewer->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
            'file_revieu' => 'review.docx',
        ]);

        $this->actingAs($this->reviewer)->put(route('reviewer.approve.chapter', $chapter->id));

        $this->assertDatabaseHas('historis', [
            'bab_id' => $chapter->id,
            'status_id' => Status::DISETUJUI,
            'action' => 'approve',
        ]);
    }

    public function test_reviewer_approve_creates_notification_for_author()
    {
        $chapter = Bab::factory()->create([
            'nama' => 'Bab Disetujui',
            'author_id' => $this->author->id,
            'reviewer_id' => $this->reviewer->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
            'file_revieu' => 'review.docx',
        ]);

        $this->actingAs($this->reviewer)->put(route('reviewer.approve.chapter', $chapter->id));

        $this->assertDatabaseHas('notifikasis', [
            'user_id' => $this->author->id,
            'bab_id' => $chapter->id,
        ]);
    }

    public function test_reviewer_revisi_creates_history()
    {
        $chapter = Bab::factory()->create([
            'nama' => 'Bab Perlu Revisi',
            'author_id' => $this->author->id,
            'reviewer_id' => $this->reviewer->id,
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
            'file_revieu' => 'review.docx',
        ]);

        $this->actingAs($this->reviewer)->put(route('reviewer.revisi.chapter', $chapter->id));

        $this->assertDatabaseHas('historis', [
            'bab_id' => $chapter->id,
            'status_id' => Status::REVISI,
            'action' => 'revisi',
        ]);
    }

    public function test_admin_approve_creates_history()
    {
        $chapter = Bab::factory()->create([
            'nama' => 'Bab ACC Admin',
            'status_id' => Status::DALAM_REVIEW,
            'file_bab' => 'bab.docx',
        ]);

        $this->actingAs($this->admin)->put(route('admin.approve.chapter', $chapter->id));

        $this->assertDatabaseHas('historis', [
            'bab_id' => $chapter->id,
            'status_id' => Status::DISETUJUI,
            'action' => 'approve',
        ]);
    }
}
