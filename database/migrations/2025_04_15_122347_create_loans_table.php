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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user') ->constrained('users',  'id')->onDelete('cascade');
            $table->foreignId('id_buku') ->constrained('books',  'id')->onDelete('cascade');
            $table->enum('status',['dipesan','dibatalkan','dipinjam','dikembalikan']);
            $table->date('batas_waktu')->nullable();
            $table->date('waktu_dipinjam')->nullable();
            $table->date('waktu_dikembalikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
