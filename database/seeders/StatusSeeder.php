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
               'option' => 'PENDING',
            ],
            [
               'option' => 'REVIEWING',
            ],
            [
               'option' => 'PUBLISHED',
            ],
            [
               'option' => 'APPROVE',
            ],
            [
               'option' => 'REJECTED',
            ],
            [
               'option' => 'SUCCESS',
            ],
            [
               'option' => 'PROCESS',
            ],
        ];
        foreach ($StatusData as $key => $val) {
            Status::create($val);
        }
    }
}
