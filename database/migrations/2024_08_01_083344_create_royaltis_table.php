<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('royaltis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produksi_id')->nullable()->constrained('Produksis')->onUpdate('set null')->onDelete('set null');
            $table->string('persentase', 20)->nullable();
            $table->string('total_royalti', 20)->nullable();
            $table->string('royalti_bab', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('royaltis');
    }
};
