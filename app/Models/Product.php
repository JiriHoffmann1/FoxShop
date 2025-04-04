<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model {
    /**
     * @var string
     */
    const
        TABLE_NAME = 'products',
        COL_ID = 'id',
        COL_CATEGORY = 'category',
        COL_NAME = 'name',
        COL_STOCK_QUANTITY = 'stock_quantity',
        COL_ACTIVE = 'active',
        COL_PRICE = 'price',
        RELATION_PRICE_CHANGES = 'priceChanges';
    protected $fillable = [
        self::COL_CATEGORY,
        self::COL_NAME,
        self::COL_ACTIVE,
        self::COL_PRICE,
        self::COL_STOCK_QUANTITY
    ];
    public function priceChanges(): BelongsTo {
        return $this->belongsTo(PriceChanges::class, PriceChanges::COL_PRODUCT_ID);
    }

}
