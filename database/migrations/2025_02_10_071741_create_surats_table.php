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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuans', 'id')->onDelete('cascade');
            $table->foreignId('jam_kerja_id')->constrained('jam_kerjas', 'id')->onDelete('cascade');
            $table->foreignId('lokasi_id')->constrained('lokasis', 'id')->onDelete('cascade');
            $table->string('nomor_surat',20)->unique()->nullable();
            // $table->date('tanggal');
            // $table->time('jam');
            // $table->string('lokasi');
            // $table->geometry('lokasi_peta', subtype: 'point', srid: 0);
            $table->string('nama_kegiatan',100);
            $table->string('nama_PJ',50);
            $table->string('jabatan_PJ',30);
            $table->string('ttd_PJ',255);
            $table->string('narahubung',50);
            $table->string('qr_validasi',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
