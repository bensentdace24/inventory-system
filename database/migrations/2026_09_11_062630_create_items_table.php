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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('serial_number')->nullable()->unique(); // Nullable for bulk supplies
            $table->string('description');
            $table->date('purchase_date');
            $table->decimal('original_cost', 12, 2);
            $table->integer('quantity')->default(0); // This becomes the dynamic "Current Quantity"
            $table->decimal('salvage_value', 12, 2)->nullable();
            $table->decimal('depreciation_expense', 12, 2)->nullable();
            $table->decimal('book_value', 12, 2)->nullable();
            $table->string('status')->default('Available');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
