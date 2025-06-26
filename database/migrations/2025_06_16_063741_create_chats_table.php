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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user')->constrained('users');
            $table->foreignId('to_user')->constrained('users');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->string('attachment')->nullable();
            $table->string('attachment_type')->nullable();
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamp('received_at')->nullable();
            $table->string('status')->default('sent');
            $table->string('chat_type')->default('private');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
