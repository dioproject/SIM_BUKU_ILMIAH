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
            $table->foreignId('buku_id')->nullable()->constrained('Bukus')->onUpdate('set null')->onDelete('set null');
            $table->string('royalti_per_bab', 20)->nullable();
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
