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
        Schema::create('session_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_session_id')->constrained('video_sessions')->onDelete('cascade');
            $table->string('type'); // 'pdf', 'video', 'image'
            $table->string('file_path'); // Path to the file in storage
            $table->string('original_filename'); // Original filename for display
            $table->string('mime_type')->nullable();
            $table->integer('file_size')->nullable(); // Size in bytes
            $table->integer('order')->default(0); // For ordering media within a session
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_media');
    }
};
