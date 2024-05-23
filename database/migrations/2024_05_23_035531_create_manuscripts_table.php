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
            $table->string('title', 250)->nullable();
            $table->text('abstract')->nullable();
            $table->longText('fill')->nullable();
            $table->dateTime('submission_date')->nullable();
            $table->string('path_foto', 200)->nullable();
            $table->foreignId('citation_id')->nullable()->constrained('Citations');
            $table->foreignId('author_id')->nullable()->constrained('Users');
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
