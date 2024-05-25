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

        Schema::create('royalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->nullable()->constrained('Books');
            $table->decimal('amount')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('path_foto', 150);
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
        Schema::dropIfExists('royalties');
    }
};