<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gender;

class GenderSeeder extends Seeder
{
    public function run()
    {
        $GendersData = [
            [
               'option' => 'MALE',
            ],
            [
               'option' => 'FEMALE',
            ],
        ];
        foreach ($GendersData as $key => $val) {
            Gender::create($val);
        }
    }
}
