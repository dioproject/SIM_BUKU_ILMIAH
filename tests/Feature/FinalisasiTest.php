<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Finalisasi;
use App\Models\Katalog;
use App\Models\Buku;

class FinalisasiTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['user_role' => 'ADMIN']);
    }

    public function test_update_finalisasi_creates_katalog_once()
    {
        $buku = Buku::factory()->create();
        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
        ]);

        $this->actingAs($this->admin)->put(route('admin.update.finalisasi', $finalisasi->id), [
            'isbn' => '9786021234567',
        ]);

        $this->assertEquals(1, Katalog::where('final_id', $finalisasi->id)->count());
    }

    public function test_update_finalisasi_does_not_duplicate_katalog()
    {
        $buku = Buku::factory()->create();
        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
        ]);

        Katalog::create(['final_id' => $finalisasi->id]);

        $this->actingAs($this->admin)->put(route('admin.update.finalisasi', $finalisasi->id), [
            'isbn' => '9786027654321',
        ]);

        $this->assertEquals(1, Katalog::where('final_id', $finalisasi->id)->count());
    }

    public function test_finalisasi_index_page_renders()
    {
        $buku = Buku::factory()->create();
        Finalisasi::create([
            'buku_id' => $buku->id,
            'isbn' => '9786021234567',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.index.finalisasi'));
        $response->assertStatus(200);
    }
}
