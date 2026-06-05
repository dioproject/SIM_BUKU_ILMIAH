<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $StatusData = [
            [
                'option' => 'Draft',
            ],
            [
                'option' => 'Tersedia',
            ],
            [
                'option' => 'Disetujui',
            ],
            [
                'option' => 'Ditugaskan',
            ],
            [
                'option' => 'Revisi',
            ],
            [
                'option' => 'Dalam Review',
            ],
        ];
        foreach ($StatusData as $key => $val) {
            Status::create($val);
        }
    }
}
