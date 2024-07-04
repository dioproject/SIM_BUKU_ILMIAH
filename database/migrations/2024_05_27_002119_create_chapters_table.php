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

        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->string('chapter', 200)->nullable();
            $table->date('deadline')->nullable();
            $table->string('file_chapter', 250)->nullable();
            $table->string('file_review', 250)->nullable();
            $table->foreignId('book_id')->nullable()->constrained('Books')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('author_id')->nullable()->constrained('Users')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('reviewer_id')->nullable()->constrained('Users')->onUpdate('set null')->onDelete('set null');
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
        Schema::dropIfExists('chapters');
    }
};
