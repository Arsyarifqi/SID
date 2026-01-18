<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // WAJIB TAMBAHKAN BARIS INI

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel residents
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->enum('status', ['new', 'processing', 'completed'])->default('new');
            $table->string('foto_proof')->nullable();
            // Menggunakan DB::raw untuk default timestamp
            $table->timestamp('reported_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complains');
    }
};