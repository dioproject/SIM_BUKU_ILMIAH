<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Royalti;
use App\Models\Produksi;
use App\Models\Finalisasi;
use App\Models\Buku;

class RoyaltiTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['user_role' => 'ADMIN']);
    }

    public function test_royalti_can_access_buku_through_chain()
    {
        $buku = Buku::factory()->create(['judul' => 'Buku Royalti Test']);
        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
        ]);
        $produksi = Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 100,
            'biaya_produksi' => 5000000,
            'harga_jual' => 100000,
        ]);
        $royalti = Royalti::create([
            'produksi_id' => $produksi->id,
            'persentase' => 10,
            'total_royalti' => 500000,
            'royalti_bab' => 50000,
        ]);

        $loaded = Royalti::with('penerbitan.final.buku')->find($royalti->id);

        $this->assertNotNull($loaded->penerbitan, 'penerbitan (Produksi) is null');
        $this->assertNotNull($loaded->penerbitan->final, 'final (Finalisasi) is null');
        $this->assertNotNull($loaded->penerbitan->final->buku, 'buku is null');
        $this->assertEquals('Buku Royalti Test', $loaded->penerbitan->final->buku->judul);
    }

    public function test_royalti_index_page_displays_buku_judul()
    {
        $buku = Buku::factory()->create(['judul' => 'Matematika Terapan']);
        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
        ]);
        $produksi = Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 50,
            'biaya_produksi' => 2000000,
            'harga_jual' => 75000,
        ]);
        Royalti::create([
            'produksi_id' => $produksi->id,
            'persentase' => 10,
            'total_royalti' => 175000,
            'royalti_bab' => 17500,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.index.royalty'));
        $response->assertStatus(200);
        $response->assertSee('Matematika Terapan');
    }

    public function test_create_royalti_page_shows_produksi_list()
    {
        $buku = Buku::factory()->create(['judul' => 'Fisika Dasar']);
        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
        ]);
        Produksi::create([
            'final_id' => $finalisasi->id,
            'eksemplar' => 100,
            'biaya_produksi' => 3000000,
            'harga_jual' => 85000,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.create.royalty'));
        $response->assertStatus(200);
    }
}
