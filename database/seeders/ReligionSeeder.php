<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Religion;

class ReligionSeeder extends Seeder
{
    public function run()
    {
        $ReligionsData = [
            [
               'option' => 'ISLAM',
            ],
            [
               'option' => 'KRISTEN',
            ],
            [
               'option' => 'KATOLIK',
            ],
            [
               'option' => 'HINDU',
            ],
            [
               'option' => 'BUDHA',
            ],
            [
               'option' => 'KONGHUCU',
            ],
        ];
        foreach ($ReligionsData as $key => $val) {
            Religion::create($val);
        }
    }
}
