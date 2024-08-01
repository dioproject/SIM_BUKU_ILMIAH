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
        Schema::create('babs', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 200)->nullable();
            $table->string('catatan', 200)->nullable();
            $table->string('file_bab', 250)->nullable();
            $table->string('file_revieu', 250)->nullable();
            $table->string('claim', 250)->nullable();
            $table->foreignId('author_id')->nullable()->constrained('Users')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('reviewer_id')->nullable()->constrained('Users')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('buku_id')->nullable()->constrained('Bukus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('status_id')->nullable()->constrained('Statuses')->onUpdate('set null')->onDelete('set null');
            $table->datetime('deadline')->nullable();
            $table->datetime('uploaded_at')->nullable();
            $table->datetime('verified_at')->nullable();
            $table->datetime('approved_at')->nullable();
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
        Schema::dropIfExists('babs');
    }
};
