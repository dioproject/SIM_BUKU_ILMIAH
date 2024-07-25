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
                'option' => 'Submit',
            ],
            [
                'option' => 'Approve',
            ],
            [
                'option' => 'Reject',
            ],
            [
                'option' => 'Revisi',
            ],
            [
                'option' => 'Publish',
            ],
        ];
        foreach ($StatusData as $key => $val) {
            Status::create($val);
        }
    }
}
