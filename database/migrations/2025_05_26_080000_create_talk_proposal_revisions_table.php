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
        Schema::create('talk_proposal_revisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talk_proposal_id');//->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('user_id');//->constrained()->onDelete('cascade'); // user who made revision
            $table->json('changes'); // JSON object to capture diff/changes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talk_proposal_revisions');
    }
};
