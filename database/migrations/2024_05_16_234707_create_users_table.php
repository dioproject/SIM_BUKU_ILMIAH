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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 50)->unique()->nullable();
            $table->string('password', 150)->nullable();
            $table->enum('user_role', ["1","2","3"])->nullable();
            $table->string('first_name', 20)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('place_of_birth', 25)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('religion', ["ISLAM","KATOLIK","KRISTEN","HINDU","BUDHA","KHONGHUCU"])->nullable();
            $table->enum('gender', ["MAN","WOMAN"])->nullable();
            $table->string('path_foto', 100)->nullable();
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
        Schema::dropIfExists('users');
    }
};
