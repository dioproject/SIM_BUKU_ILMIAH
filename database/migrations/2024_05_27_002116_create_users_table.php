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

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 50)->unique()->nullable();
            $table->string('password', 150)->nullable();
            $table->enum('user_role', ["ADMIN","EDITOR","AUTHOR"])->nullable();
            $table->string('first_name', 30)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('place_of_birth', 100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('contact', 30)->nullable();
            $table->foreignId('religion_id')->nullable()->constrained('Religions')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('gender_id')->nullable()->constrained('Genders')->onUpdate('set null')->onDelete('set null');
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
        Schema::dropIfExists('users');
    }
};
