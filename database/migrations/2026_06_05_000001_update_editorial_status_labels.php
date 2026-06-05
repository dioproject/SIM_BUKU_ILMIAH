<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $statuses = [
            1 => 'Draft',
            2 => 'Tersedia',
            3 => 'Disetujui',
            4 => 'Ditugaskan',
            5 => 'Revisi',
            6 => 'Dalam Review',
            7 => 'Dikirim Author',
            8 => 'Direvisi',
            9 => 'Finalisasi',
            10 => 'Terbit',
        ];

        foreach ($statuses as $id => $option) {
            DB::table('statuses')->updateOrInsert(
                ['id' => $id],
                ['option' => $option, 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }

    public function down()
    {
        $statuses = [
            1 => 'Pending',
            2 => 'Available',
            3 => 'Approve',
            4 => 'Claimed',
            5 => 'Revisi',
            6 => 'Selected',
            7 => 'Dikirim Author',
            8 => 'Direvisi',
            9 => 'Finalisasi',
            10 => 'Terbit',
        ];

        foreach ($statuses as $id => $option) {
            DB::table('statuses')->where('id', $id)->update([
                'option' => $option,
                'updated_at' => now(),
            ]);
        }
    }
};
