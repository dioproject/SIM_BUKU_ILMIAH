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

        Schema::create('manuscripts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->text('abstract')->nullable();
            $table->longText('fill')->nullable();
            $table->date('submission_date')->nullable();
            $table->enum('status', ["SUBMITTED","REVIEWING","PUBLISHED","REJECTED"])->nullable();
            $table->foreignId('author_id')->nullable()->constrained('Users');
            $table->foreignId('book_id')->nullable()->constrained('Books');
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
        Schema::dropIfExists('manuscripts');
    }
};
