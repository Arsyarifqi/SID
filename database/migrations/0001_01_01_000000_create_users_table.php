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
        // 1. Tabel Roles (Harus dibuat lebih dulu karena User merujuk ke sini)
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Admin, Warga
            $table->timestamps();
        });

        // 2. Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Kolom NIK ditambahkan di sini [PENTING]
            $table->string('nik', 16)->unique()->comment('Nomor Induk Kependudukan');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            /** * Status Akun:
             * submitted = Baru daftar, butuh verifikasi
             * approved  = Sudah diverifikasi, bisa login
             * rejected  = Ditolak admin
             */
            $table->enum('status', ['submitted', 'approved', 'rejected'])->default('submitted');
            
            // Relasi ke Role
            $table->unsignedBigInteger('role_id')->default(2); // Default 2 (Warga)
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            
            $table->rememberToken();
            $table->timestamps();
        });
        
        // 3. Tabel Sessions (Penting untuk autentikasi database)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};