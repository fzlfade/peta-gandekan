<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik');
            $table->text('alamat');
            $table->double('latitude', 15, 10);
            $table->double('longitude', 15, 10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
