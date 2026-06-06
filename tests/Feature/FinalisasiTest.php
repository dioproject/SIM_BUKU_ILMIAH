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

    public function test_update_finalisasi_updates_isbn()
    {
        $buku = Buku::factory()->create();
        $finalisasi = Finalisasi::create([
            'buku_id' => $buku->id,
        ]);

        $this->actingAs($this->admin)->put(route('admin.update.finalisasi', $finalisasi->id), [
            'isbn' => '9786021234567',
        ]);

        $this->assertDatabaseHas('finalisasis', [
            'id' => $finalisasi->id,
            'isbn' => '9786021234567',
        ]);
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
