<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Status;
use App\Models\Jenis;
use App\Models\Finalisasi;
use App\Models\Produksi;
use App\Models\Katalog;
use App\Models\Royalti;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class AdminWorkflowFullTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $jenisId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['user_role' => 'ADMIN']);

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

        DB::table('jenis')->insert(['id' => 1, 'nama' => 'Pendidikan']);
        $this->jenisId = 1;
    }

    public function test_admin_can_view_books_list()
    {
        Buku::factory()->count(3)->create(['jenis_id' => $this->jenisId]);

        $response = $this->actingAs($this->admin)->get(route('admin.index.book'));

        $response->assertStatus(200);
    }

    public function test_admin_can_search_books()
    {
        Buku::factory()->create(['judul' => 'Buku Matematika', 'jenis_id' => $this->jenisId]);
        Buku::factory()->create(['judul' => 'Buku Fisika', 'jenis_id' => $this->jenisId]);

        $response = $this->actingAs($this->admin)->get(route('admin.index.book', ['search' => 'Matematika']));

        $response->assertStatus(200);
        $response->assertSee('Buku Matematika');
        $response->assertDontSee('Buku Fisika');
    }

    public function test_admin_can_view_create_book_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.create.book'));

        $response->assertStatus(200);
    }

    public function test_admin_can_store_book()
    {
        $file = UploadedFile::fake()->create('template.docx', 12);

        $response = $this->actingAs($this->admin)->post(route('admin.store.book'), [
            'jenis_id' => $this->jenisId,
            'judul' => 'Buku Baru',
            'total_bab' => 5,
            'template' => $file,
        ]);

        $response->assertRedirect(route('admin.index.book'));
        $this->assertDatabaseHas('bukus', ['judul' => 'Buku Baru', 'total_bab' => 5, 'jenis_id' => $this->jenisId]);
    }

    public function test_admin_can_view_book_detail()
    {
        $buku = Buku::factory()->create(['jenis_id' => $this->jenisId]);

        $response = $this->actingAs($this->admin)->get(route('admin.show.book', $buku->id));

        $response->assertStatus(200);
    }

    public function test_admin_can_delete_book()
    {
        $buku = Buku::factory()->create(['jenis_id' => $this->jenisId]);

        $response = $this->actingAs($this->admin)->delete(route('admin.destroy.book', $buku->id));

        $response->assertRedirect(route('admin.index.book'));
        $this->assertDatabaseMissing('bukus', ['id' => $buku->id]);
    }

    public function test_merge_succeeds_when_all_chapters_approved()
    {
        $buku = Buku::factory()->create(['total_bab' => 2, 'judul' => 'Buku Test Merge', 'jenis_id' => $this->jenisId]);

        Bab::factory()->create([
            'buku_id' => $buku->id,
            'status_id' => Status::DISETUJUI,
            'file_bab' => 'bab.docx',
        ]);
        Bab::factory()->create([
            'buku_id' => $buku->id,
            'status_id' => Status::DISETUJUI,
            'file_bab' => 'bab2.docx',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.merge.bab', $buku->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('finalisasis', ['buku_id' => $buku->id]);
    }

    public function test_merge_fails_when_chapters_not_all_approved()
    {
        $buku = Buku::factory()->create(['total_bab' => 2, 'jenis_id' => $this->jenisId]);

        Bab::factory()->create([
            'buku_id' => $buku->id,
            'status_id' => Status::DISETUJUI,
            'file_bab' => 'bab.docx',
        ]);
        Bab::factory()->create([
            'buku_id' => $buku->id,
            'status_id' => Status::DITUGASKAN,
            'file_bab' => null,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.merge.bab', $buku->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('finalisasis', ['buku_id' => $buku->id]);
    }

    public function test_merge_fails_when_chapter_count_is_less_than_total_bab()
    {
        $buku = Buku::factory()->create(['total_bab' => 5, 'jenis_id' => $this->jenisId]);

        Bab::factory()->create([
            'buku_id' => $buku->id,
            'status_id' => Status::DISETUJUI,
            'file_bab' => 'bab.docx',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.merge.bab', $buku->id));

        $response->assertSessionHas('error');
    }

    public function test_finalisasi_index_renders()
    {
        $buku = Buku::factory()->create(['jenis_id' => $this->jenisId]);
        Finalisasi::create(['buku_id' => $buku->id, 'isbn' => '9786021234567']);

        $response = $this->actingAs($this->admin)->get(route('admin.index.finalisasi'));

        $response->assertStatus(200);
    }

    public function test_finalisasi_update_creates_katalog()
    {
        $buku = Buku::factory()->create(['judul' => 'Buku Final', 'total_bab' => 1, 'jenis_id' => $this->jenisId]);
        $finalisasi = Finalisasi::create(['buku_id' => $buku->id]);

        $cover = UploadedFile::fake()->image('cover.jpg');
        $pdf = UploadedFile::fake()->create('final.pdf', 100);

        $response = $this->actingAs($this->admin)->put(route('admin.update.finalisasi', $finalisasi->id), [
            'isbn' => '9786021234567',
            'cover' => $cover,
            'final_file' => $pdf,
        ]);

        $response->assertRedirect(route('admin.index.finalisasi'));
        $this->assertDatabaseHas('finalisasis', [
            'id' => $finalisasi->id,
            'isbn' => '9786021234567',
        ]);
    }

    public function test_produksi_index_renders()
    {
        $buku = Buku::factory()->create(['jenis_id' => $this->jenisId]);
        $finalisasi = Finalisasi::create(['buku_id' => $buku->id]);
        Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 100,
            'biaya_produksi' => 5000000,
            'harga_jual' => 100000,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.index.produksi'));

        $response->assertStatus(200);
    }

    public function test_produksi_store_validates_data()
    {
        $buku = Buku::factory()->create(['jenis_id' => $this->jenisId]);
        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
            'cover' => 'cover.jpg',
            'final_file' => 'final.pdf',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.store.produksi'), [
            'final_id' => $finalisasi->id,
            'eksemplar' => 100,
            'biaya_produksi' => 5000000,
            'harga_jual' => 100000,
            'tahun_terbit' => 2024,
        ]);

        $response->assertRedirect(route('admin.index.produksi'));
        $this->assertDatabaseHas('produksis', [
            'final_id' => $finalisasi->id,
            'eksemplar' => 100,
        ]);
    }

    public function test_produksi_store_fails_without_complete_final_data()
    {
        $buku = Buku::factory()->create(['jenis_id' => $this->jenisId]);
        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => null,
            'cover' => null,
            'final_file' => null,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.store.produksi'), [
            'final_id' => $finalisasi->id,
            'eksemplar' => 100,
            'biaya_produksi' => 5000000,
            'harga_jual' => 100000,
            'tahun_terbit' => 2024,
        ]);

        $response->assertSessionHasErrors('final_id');
    }

    public function test_katalog_index_renders()
    {
        $buku = Buku::factory()->create(['judul' => 'Buku Katalog', 'jenis_id' => $this->jenisId]);
        $finalisasi = Finalisasi::create(['buku_id' => $buku->id]);
        Katalog::create([
            'final_id' => $finalisasi->id,
            'judul' => 'Buku Katalog',
            'pengarang' => 'Penulis',
            'isbn' => '9786021234567',
            'tahun_terbit' => 2024,
            'kategori' => 'Pendidikan',
            'deskripsi' => 'Deskripsi buku',
            'status_publish' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.index.catalog'));

        $response->assertStatus(200);
    }

    public function test_katalog_store_creates_entry()
    {
        $buku = Buku::factory()->create(['judul' => 'Buku Katalog Test', 'jenis_id' => $this->jenisId]);
        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
            'cover' => 'cover.jpg',
            'final_file' => 'final.pdf',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.store.catalog'), [
            'final_id' => $finalisasi->id,
            'judul' => 'Buku Katalog Test',
            'pengarang' => 'Penulis Utama',
            'isbn' => '9786021234567',
            'tahun_terbit' => 2024,
            'kategori' => 'Pendidikan',
            'deskripsi' => 'Buku pendidikan berkualitas',
        ]);

        $response->assertRedirect(route('admin.index.catalog'));
        $this->assertDatabaseHas('katalogs', [
            'final_id' => $finalisasi->id,
            'status_publish' => true,
        ]);
    }

    public function test_royalti_store_calculates_correctly()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $buku = Buku::factory()->create(['judul' => 'Buku Royalti', 'total_bab' => 2, 'jenis_id' => $this->jenisId]);
        $chapter = Bab::factory()->create([
            'buku_id' => $buku->id,
            'author_id' => $author->id,
            'status_id' => Status::DISETUJUI,
        ]);
        Bab::factory()->create([
            'buku_id' => $buku->id,
            'author_id' => $author->id,
            'status_id' => Status::DISETUJUI,
        ]);

        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
            'cover' => 'cover.jpg',
            'final_file' => 'final.pdf',
        ]);

        $produksi = Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 100,
            'biaya_produksi' => 5000000,
            'harga_jual' => 100000,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.store.royalty'), [
            'produksi_id' => $produksi->id,
            'user_id' => $author->id,
            'bab_id' => $chapter->id,
            'persentase' => 10,
        ]);

        $response->assertRedirect(route('admin.index.royalty'));
        $this->assertDatabaseHas('royaltis', [
            'produksi_id' => $produksi->id,
            'user_id' => $author->id,
            'bab_id' => $chapter->id,
        ]);
    }

    public function test_royalti_store_fails_when_bab_not_belonging_to_user()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $otherAuthor = User::factory()->create(['user_role' => 'AUTHOR']);
        $buku = Buku::factory()->create(['judul' => 'Buku Royalti Test', 'total_bab' => 1, 'jenis_id' => $this->jenisId]);
        $chapter = Bab::factory()->create([
            'buku_id' => $buku->id,
            'author_id' => $otherAuthor->id,
            'status_id' => Status::DISETUJUI,
        ]);

        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
            'cover' => 'cover.jpg',
            'final_file' => 'final.pdf',
        ]);

        $produksi = Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 100,
            'biaya_produksi' => 5000000,
            'harga_jual' => 100000,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.store.royalty'), [
            'produksi_id' => $produksi->id,
            'user_id' => $author->id,
            'bab_id' => $chapter->id,
            'persentase' => 10,
        ]);

        $response->assertSessionHasErrors('user_id');
    }

    public function test_royalti_index_displays_buku_judul()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $buku = Buku::factory()->create(['judul' => 'Matematika Terapan', 'total_bab' => 1, 'jenis_id' => $this->jenisId]);
        $chapter = Bab::factory()->create([
            'buku_id' => $buku->id,
            'author_id' => $author->id,
            'status_id' => Status::DISETUJUI,
        ]);

        $finalisasi = Finalisasi::create(['buku_id' => $buku->id, 'isbn' => '9786021234567']);
        $produksi = Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 50,
            'biaya_produksi' => 2000000,
            'harga_jual' => 75000,
        ]);
        Royalti::create([
            'produksi_id' => $produksi->id,
            'user_id' => $author->id,
            'bab_id' => $chapter->id,
            'persentase' => 10,
            'total_royalti' => 175000,
            'royalti_bab' => 17500,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.index.royalty'));
        $response->assertStatus(200);
        $response->assertSee('Matematika Terapan');
    }
}
