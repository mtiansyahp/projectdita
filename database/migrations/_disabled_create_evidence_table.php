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
        Schema::create('evidence', function (Blueprint $table) {
            $table->uuid('evidence_id')->primary(); // PK unik untuk evidence
            $table->uuid('id'); // = approval_id = foreign key dari approval_pelaporan.id
            $table->string('name');
            $table->text('url');
            $table->string('user_maker');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('tanggal_approve')->nullable();
            $table->string('status_approve');
            $table->integer('approval_sequence');
            $table->foreign('id')->references('id')->on('approval_pelaporan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidence');
    }
};
