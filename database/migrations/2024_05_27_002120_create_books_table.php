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
            $table->string('script', 200)->nullable();
            $table->string('template', 200)->nullable();
            $table->string('review', 200)->nullable();
            $table->foreignId('category_id')->nullable()->constrained('Categories')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('status_id')->nullable()->constrained('Statuses')->onUpdate('set null')->onDelete('set null');
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
        Schema::dropIfExists('books');
    }
};
