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
        Schema::create('finalisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->nullable()->constrained('Bukus')->onUpdate('cascade')->onDelete('cascade');
            $table->string('merge', 250)->nullable();
            $table->string('isbn', 250)->nullable();
            $table->string('cover', 250)->nullable();
            $table->string('final_file', 250)->nullable();
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
        Schema::dropIfExists('finalisasis');
    }
};
