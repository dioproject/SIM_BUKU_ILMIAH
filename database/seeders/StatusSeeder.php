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
                'option' => 'Pending',
            ],
            [
                'option' => 'Available',
            ],
            [
                'option' => 'Approve',
            ],
            [
                'option' => 'Claimed',
            ],
            [
                'option' => 'Revisi',
            ],
            [
                'option' => 'Selected',
            ],
        ];
        foreach ($StatusData as $key => $val) {
            Status::create($val);
        }
    }
}
