<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->integer('infaq_nominal')->nullable()->after('bukti_pembayaran');
            $table->string('bukti_infaq')->nullable()->after('infaq_nominal');
            $table->text('motivasi_kajian')->nullable()->after('bukti_infaq');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['infaq_nominal', 'bukti_infaq', 'motivasi_kajian']);
        });
    }
};
