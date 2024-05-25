<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $CategoryData = [
            [
               'name' => 'Jurnal',
            ],
            [
               'name' => 'Buku Ilmiah',
            ],
            [
               'name' => 'Makalah',
            ],
        ];
        foreach ($CategoryData as $key => $val) {
            Category::create($val);
        }
    }
}
