<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Histori: tambah user_id, bab_id, status_id, action
        Schema::table('historis', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('bab_id')->nullable()->after('user_id')->constrained('babs')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('status_id')->nullable()->after('bab_id')->constrained('statuses')->onUpdate('set null')->onDelete('set null');
            $table->string('action', 50)->nullable()->after('status_id');
        });

        // Notifikasi: tambah bab_id
        Schema::table('notifikasis', function (Blueprint $table) {
            $table->foreignId('bab_id')->nullable()->after('user_id')->constrained('babs')->onUpdate('set null')->onDelete('set null');
        });

        // Katalog: tambah field untuk data final buku
        Schema::table('katalogs', function (Blueprint $table) {
            $table->string('judul')->nullable()->after('final_id');
            $table->text('pengarang')->nullable()->after('judul');
            $table->string('isbn', 30)->nullable()->after('pengarang');
            $table->year('tahun_terbit')->nullable()->after('isbn');
            $table->string('kategori')->nullable()->after('tahun_terbit');
            $table->text('deskripsi')->nullable()->after('kategori');
            $table->string('cover')->nullable()->after('deskripsi');
            $table->boolean('status_publish')->default(false)->after('cover');
        });

        // Produksi: tambah tahun_terbit
        Schema::table('produksis', function (Blueprint $table) {
            $table->year('tahun_terbit')->nullable()->after('harga_jual');
        });

        // Royalti: tambah user_id, bab_id
        Schema::table('royaltis', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('produksi_id')->constrained('users')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('bab_id')->nullable()->after('user_id')->constrained('babs')->onUpdate('set null')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('royaltis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['bab_id']);
            $table->dropColumn(['user_id', 'bab_id']);
        });

        Schema::table('produksis', function (Blueprint $table) {
            $table->dropColumn('tahun_terbit');
        });

        Schema::table('katalogs', function (Blueprint $table) {
            $table->dropColumn(['judul', 'pengarang', 'isbn', 'tahun_terbit', 'kategori', 'deskripsi', 'cover', 'status_publish']);
        });

        Schema::table('notifikasis', function (Blueprint $table) {
            $table->dropForeign(['bab_id']);
            $table->dropColumn('bab_id');
        });

        Schema::table('historis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['bab_id']);
            $table->dropForeign(['status_id']);
            $table->dropColumn(['user_id', 'bab_id', 'status_id', 'action']);
        });
    }
};
