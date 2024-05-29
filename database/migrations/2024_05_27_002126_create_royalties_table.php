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
            $table->foreignId('book_id')->nullable()->constrained('Books')->onUpdate('cascade')->onDelete('cascade');
            $table->string('amount', 200)->nullable();
            $table->string('path_foto', 200)->nullable();
            $table->foreignId('status_id')->nullable()->constrained('Statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('author_id')->nullable()->constrained('Users')->onUpdate('set null')->onDelete('set null');
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
