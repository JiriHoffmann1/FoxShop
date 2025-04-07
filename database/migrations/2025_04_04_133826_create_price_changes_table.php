<?php

use App\Models\PriceChange;
use App\Models\Product;
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
        Schema::create(PriceChange::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId(PriceChange::COL_PRODUCT_ID)->constrained()->references(Product::COL_ID)->on(Product::TABLE_NAME)->onDelete('cascade');
            $table->decimal(PriceChange::COL_NEW_PRICE, 10, 2);
            $table->decimal(PriceChange::COL_OLD_PRICE, 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(PriceChange::TABLE_NAME);
    }
};
