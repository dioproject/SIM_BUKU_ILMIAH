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

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250)->nullable();
            $table->string('template', 250)->nullable();
            $table->foreignId('status_id')->nullable()->constrained('Statuses')->onUpdate('set null')->onDelete('set null');
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
        Schema::dropIfExists('books');
    }
};
