<?php

namespace Webkul\AI\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Customer\Models\Customer as BaseCustomer;
use Webkul\Product\Models\Product as BaseProduct;

class Recommendation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ai_recommendations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'session_id',
        'product_id',
        'recommended_product_id',
        'score',
        'type',
        'context',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'score'      => 'float',
        'context'    => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * The product the recommendation is based on.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(BaseProduct::class, 'product_id');
    }

    /**
     * The recommended product.
     *
     * @return BelongsTo
     */
    public function recommendedProduct(): BelongsTo
    {
        return $this->belongsTo(BaseProduct::class, 'recommended_product_id');
    }

    /**
     * The customer the recommendation is for.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(BaseCustomer::class, 'customer_id');
    }
}
