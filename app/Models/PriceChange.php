<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceChange extends Model {
    /**
     * @var string
     */
    const TABLE_NAME = 'price_changes',
        COL_ID = 'id',
        COL_PRODUCT_ID = 'product_id',
        COL_OLD_PRICE = 'old_price',
        COL_NEW_PRICE = 'new_price',
        COL_CREATED_AT = 'created_at',
        RELATION_PRODUCT = 'product';
    protected $fillable = [
        self::COL_PRODUCT_ID,
        self::COL_OLD_PRICE,
        self::COL_NEW_PRICE,
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, self::COL_PRODUCT_ID);
    }
}
