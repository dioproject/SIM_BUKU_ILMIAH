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

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->enum('type', ["Template","Chapter","Review"]);
            $table->foreignId('chapter_id')->nullable()->constrained('Chapters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('Users')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('status_id')->nullable()->constrained('Statuses')->onUpdate('set null')->onDelete('set null');
            $table->date('deadline')->nullable();
            $table->date('uploaded_at')->nullable();
            $table->date('verified_at')->nullable();
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
        Schema::dropIfExists('files');
    }
};
