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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('bukus', 'id')->onDelete('cascade');
            $table->string('nama_peminjam');
            $table->dateTime('tgl_peminjaman');
            $table->dateTime('tgl_tenggat');
            $table->dateTime('tgl_pengembalian')->nullable();
            $table->string('status')->default('aktif');
            
            $table->decimal('denda', 8, 2)->default(0); // Fine amount
            $table->string('kondisi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
