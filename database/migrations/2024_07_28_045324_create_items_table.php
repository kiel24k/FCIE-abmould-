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
            $table->bigInteger('user_id');
            $table->string('item_code')->nullable();
            $table->string('supplier_name')->nullable();
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('treshold')->nullable();
            $table->string('category');
            $table->string('out_of_stock_notif')->nullable();
            $table->string('description');
            $table->string('brand')->nuillable();
            $table->date('release_date')->nullable();
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
