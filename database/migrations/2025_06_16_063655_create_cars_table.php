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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->string('type');
            $table->double('price');
            $table->string('vin');
            $table->integer('miles');
            $table->enum('fuel_type', ['hybrid', 'diesel', 'petrol', 'electric']);
            $table->string('address');
            $table->string('phone');
            $table->text('specification')->nullable();
            $table->text('description');
            $table->json('images')->nullable();
            $table->enum('status', ['sale', 'sold'])->default('sale');
            $table->foreignId('sold_to_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
