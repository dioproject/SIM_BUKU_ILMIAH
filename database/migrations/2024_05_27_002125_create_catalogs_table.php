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
        Schema::disableForeignKeyConstraints();

        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->nullable()->constrained('Books')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('path_foto', 200)->nullable();
            $table->foreignId('status_id')->nullable()->constrained('Statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogs');
    }
};
