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
        Schema::create('talk_proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('speaker_id');//->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('presentation_pdf')->nullable(); // file path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talk_proposals');
    }
};
