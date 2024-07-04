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
               'option' => 'Reviewing',
            ],
            [
               'option' => 'Published',
            ],
            [
               'option' => 'Approve',
            ],            
            [
               'option' => 'Accept',
            ],
            [
               'option' => 'Submit',
            ],
            [
               'option' => 'Rejected',
            ],
            [
               'option' => 'Success',
            ],
            [
               'option' => 'Process',
            ],
        ];
        foreach ($StatusData as $key => $val) {
            Status::create($val);
        }
    }
}
