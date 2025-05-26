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
        Schema::create('talk_proposal_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('talk_proposal_id');//->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('tag_id');//->constrained()->onDelete('cascade');
            $table->primary(['talk_proposal_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talk_proposal_tag');
    }
};
