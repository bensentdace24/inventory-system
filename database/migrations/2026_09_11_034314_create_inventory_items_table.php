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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();

            // Unique tag/serial number engraved or stickered on the asset.
            $table->string('asset_serial_number')->unique();

            // Human readable description of the item.
            $table->text('item_description');

            // When the item was purchased / acquired.
            $table->date('acquisition_date');

            // Original purchase price.
            $table->decimal('cost', 14, 2)->default(0);

            // Quantity originally acquired.
            $table->integer('quantity')->default(1);

            // Date the item was withdrawn/issued out of the stockroom.
            $table->date('date_of_withdrawal')->nullable();

            // Quantity still left in inventory (on hand).
            $table->integer('remaining_quantity')->default(0);

            // Date the item was returned to the stockroom (if applicable).
            $table->date('date_of_returned')->nullable();

            // Salvage / residual value at the end of useful life.
            $table->decimal('salvage_value', 14, 2)->default(0);

            // Person/office the asset is assigned/issued to.
            $table->string('custodian');

            // Accumulated/periodic depreciation expense.
            $table->decimal('depreciation_expense', 14, 2)->default(0);

            // Net book value = cost - depreciation expense.
            $table->decimal('book_value', 14, 2)->default(0);

            // Free-form status / remarks (e.g. Serviceable, For Repair, Disposed).
            $table->string('status_remarks')->default('Serviceable');

            $table->timestamps();

            $table->index('custodian');
            $table->index('status_remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
