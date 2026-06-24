<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('qris_image')->nullable()->after('harga');
            $table->string('nama_bank')->nullable()->after('qris_image');
            $table->string('no_rekening')->nullable()->after('nama_bank');
            $table->string('nama_rekening')->nullable()->after('no_rekening');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['qris_image', 'nama_bank', 'no_rekening', 'nama_rekening']);
        });
    }
};
