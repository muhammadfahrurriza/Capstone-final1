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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('id_user');
            // $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('tgl_pengajuan');
            $table->dateTime('tgl_diterima_admin')->nullable();
            $table->dateTime('tgl_ditolak_admin')->nullable();
            $table->dateTime('tgl_diterima_sekdin')->nullable();
            $table->dateTime('tgl_ditolak_sekdin')->nullable();
            $table->dateTime('tgl_diterima_kadin')->nullable();
            $table->dateTime('tgl_ditolak_kadin')->nullable();
            $table->string('keterangan_admin',1000)->nullable();
            $table->string('keterangan_sekdin',1000)->nullable();
            $table->string('keterangan_kadin',1000)->nullable();
            $table->enum('status_admin', [
                'Diterima Admin', 
                'Ditolak Admin',])->nullable();
                $table->enum('status_sekdin', [
                'Diterima Sekdin', 
                'Ditolak Sekdin',])->nullable();
            $table->enum('status_kadin', [
                'Diterima Kadin', 
                'Ditolak Kadin',])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
