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
        Schema::create('reimburses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('bbm_id')->constrained('bbms', 'id')->onDelete('cascade')->nullable();
            // $table->foreignId('souvenir_id')->constrained('souvenirs', 'id')->onDelete('cascade')->nullable();
            $table->dateTime('tgl_pengajuan')->nullable();
            $table->dateTime('tgl_diterima')->nullable();
            $table->dateTime('tgl_ditolak');
            $table->string('status');
            $table->integer('biaya');
            $table->enum('jenis_reimburse', ['bbm', 'souvenir'])->default('bbm');
            $table->string('foto_bukti',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimburses');
    }
};
