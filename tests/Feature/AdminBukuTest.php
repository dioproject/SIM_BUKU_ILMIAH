<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Buku;
use App\Models\Jenis;
use App\Models\Status;
use App\Models\Bab;
use Illuminate\Http\UploadedFile;

class AdminBukuTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['user_role' => 'ADMIN']);
    }

    public function test_admin_can_view_books_list()
    {
        Buku::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.index.book'));

        $response->assertStatus(200);
    }

    public function test_admin_can_search_books_by_judul()
    {
        Buku::factory()->create(['judul' => 'Matematika Dasar']);
        Buku::factory()->create(['judul' => 'Fisika Lanjutan']);

        $response = $this->actingAs($this->admin)->get(route('admin.index.book', ['search' => 'Matematika']));

        $response->assertStatus(200);
        $response->assertSee('Matematika Dasar');
        $response->assertDontSee('Fisika Lanjutan');
    }

    public function test_admin_can_view_create_book_page()
    {
        Jenis::create(['nama' => 'Pendidikan']);

        $response = $this->actingAs($this->admin)->get(route('admin.create.book'));

        $response->assertStatus(200);
    }

    public function test_admin_can_delete_book()
    {
        $buku = Buku::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.destroy.book', $buku->id));

        $response->assertRedirect(route('admin.index.book'));
        $this->assertDatabaseMissing('bukus', ['id' => $buku->id]);
    }

    public function test_admin_cannot_access_if_not_admin()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);

        $response = $this->actingAs($author)->get(route('admin.index.book'));

        $response->assertStatus(403);
    }

    public function test_admin_can_store_chapter()
    {
        Status::create(['option' => 'Menunggu']);
        Status::create(['option' => 'Tersedia']);
        Status::create(['option' => 'Disetujui']);
        $buku = Buku::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('admin.store.chapter', $buku->id), [
            'bab' => ['Bab 1', 'Bab 2'],
        ]);

        $response->assertRedirect(route('admin.show.book', $buku->id));
        $this->assertDatabaseHas('babs', ['nama' => 'Bab 1', 'buku_id' => $buku->id]);
        $this->assertDatabaseHas('babs', ['nama' => 'Bab 2', 'buku_id' => $buku->id]);
    }
}
