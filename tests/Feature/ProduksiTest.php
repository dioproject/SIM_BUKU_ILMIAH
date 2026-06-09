<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Buku;
use App\Models\Produksi;
use App\Models\Finalisasi;

class ProduksiTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['user_role' => 'ADMIN']);
    }

    public function test_produksi_index_page_renders()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.index.produksi'));
        $response->assertStatus(200);
    }

    public function test_produksi_create_page_renders()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.create.produksi'));
        $response->assertStatus(200);
    }

    public function test_produksi_store_creates_new_produksi()
    {
        $buku = Buku::factory()->create();
        $finalisasi = Finalisasi::create(['buku_id' => $buku->id]);

        $this->actingAs($this->admin)->post(route('admin.store.produksi'), [
            'final_id' => $finalisasi->id,
            'eksemplar' => 1000,
            'tahun_terbit' => 2026,
            'biaya_produksi' => 50000000,
            'harga_jual' => 75000,
        ]);

        $this->assertDatabaseHas('produksis', [
            'final_id' => $finalisasi->id,
            'eksemplar' => 1000,
            'tahun_terbit' => 2026,
        ]);
    }

    public function test_produksi_show_page_renders()
    {
        $buku = Buku::factory()->create();
        $finalisasi = Finalisasi::create(['buku_id' => $buku->id]);
        $produksi = Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 1000,
            'tahun_terbit' => 2026,
            'biaya_produksi' => 50000000,
            'harga_jual' => 75000,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.show.produksi', $produksi->id));
        $response->assertStatus(200);
        $response->assertSee('1000');
    }

    public function test_produksi_edit_page_renders()
    {
        $buku = Buku::factory()->create();
        $finalisasi = Finalisasi::create(['buku_id' => $buku->id]);
        $produksi = Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 1000,
            'tahun_terbit' => 2026,
            'biaya_produksi' => 50000000,
            'harga_jual' => 75000,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.edit.produksi', $produksi->id));
        $response->assertStatus(200);
    }

    public function test_produksi_update_modifies_produksi()
    {
        $buku = Buku::factory()->create();
        $finalisasi = Finalisasi::create(['buku_id' => $buku->id]);
        $produksi = Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 1000,
            'tahun_terbit' => 2026,
            'biaya_produksi' => 50000000,
            'harga_jual' => 75000,
        ]);

        $this->actingAs($this->admin)->put(route('admin.update.produksi', $produksi->id), [
            'eksemplar' => 2000,
            'tahun_terbit' => 2027,
            'biaya_produksi' => 100000000,
            'harga_jual' => 85000,
        ]);

        $this->assertDatabaseHas('produksis', [
            'id' => $produksi->id,
            'eksemplar' => 2000,
            'tahun_terbit' => 2027,
        ]);
    }

    public function test_produksi_destroy_deletes_produksi()
    {
        $buku = Buku::factory()->create();
        $finalisasi = Finalisasi::create(['buku_id' => $buku->id]);
        $produksi = Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 1000,
            'tahun_terbit' => 2026,
            'biaya_produksi' => 50000000,
            'harga_jual' => 75000,
        ]);

        $this->actingAs($this->admin)->delete(route('admin.destroy.produksi', $produksi->id));

        $this->assertDatabaseMissing('produksis', [
            'id' => $produksi->id,
        ]);
    }

    public function test_non_admin_cannot_access_produksi_routes()
    {
        $author = User::factory()->create(['user_role' => 'AUTHOR']);
        $reviewer = User::factory()->create(['user_role' => 'REVIEWER']);

        $response = $this->actingAs($author)->get(route('admin.index.produksi'));
        $response->assertStatus(403);

        $response = $this->actingAs($reviewer)->get(route('admin.index.produksi'));
        $response->assertStatus(403);
    }
}
