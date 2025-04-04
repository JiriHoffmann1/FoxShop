<?php

use App\Enums\CategoryNames;
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
        Schema::create(Product::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(Product::COL_NAME);
            $table->enum(Product::COL_CATEGORY, array_column(CategoryNames::cases(), 'value'));
            $table->decimal(Product::COL_PRICE, 10, 2);
            $table->boolean(Product::COL_ACTIVE)->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Product::TABLE_NAME);
    }
};
