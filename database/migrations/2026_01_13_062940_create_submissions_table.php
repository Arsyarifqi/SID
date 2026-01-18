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
    Schema::create('submissions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
        $table->string('type'); // Jenis Surat (Domisili, SKTM, dll)
        $table->text('necessity'); // Keperluan pengajuan
        $table->enum('status', ['pending', 'approved', 'rejected', 'ready'])->default('pending');
        $table->text('admin_note')->nullable(); // Catatan jika ditolak atau info pengambilan
        $table->string('file_path')->nullable(); // Jika surat sudah jadi PDF (opsional)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
