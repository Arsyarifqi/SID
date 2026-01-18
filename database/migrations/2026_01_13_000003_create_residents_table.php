<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nik', 16)->unique(); 
            $table->string('name', 100);
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('birth_place', 100);
            $table->text('address');
            
            // Cukup panggil relasinya saja, jangan buat tabelnya di sini
            $table->foreignId('rw_unit_id')->nullable()->constrained('rw_units')->onDelete('set null');
            $table->foreignId('rt_unit_id')->nullable()->constrained('rt_units')->onDelete('set null');
            
            $table->string('religion', 50)->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('occupation', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->enum('status', ['active', 'moved', 'deceased'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};