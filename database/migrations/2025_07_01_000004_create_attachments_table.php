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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id(); // BIGINT PK
            $table->foreignId('requirement_id')->constrained()->onDelete('cascade');
            $table->string('path'); // Path to the file in storage
            $table->string('filename'); // Original filename
            $table->string('filetype')->nullable(); // e.g., 'image/png'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
