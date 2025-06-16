<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('_detail_pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->table('id_pelanggar');
            $table->table('id_pelanggaran');
            $table->table('id_user');
            $table->table('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailpelanggars');
    }
};
