<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $StatusData = [
            [
                'nama' => 'Fiksi',
            ],
            [
                'nama' => 'Non Fiksi',
            ],
        ];
        foreach ($StatusData as $key => $val) {
            Jenis::create($val);
        }
    }
}
