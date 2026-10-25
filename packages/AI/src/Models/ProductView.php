<?php

namespace Webkul\AI\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Product\Models\Product as BaseProduct;
use Webkul\Customer\Models\Customer as BaseCustomer;

class ProductView extends Model
{
    protected $table = 'ai_product_views';

    protected $fillable = [
        'product_id',
        'customer_id',
        'session_id',
        'ip_address',
        'user_agent',
        'referrer',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the product that was viewed.
     */
    public function product()
    {
        return $this->belongsTo(BaseProduct::class, 'product_id');
    }

    /**
     * Get the customer who viewed the product.
     */
    public function customer()
    {
        return $this->belongsTo(BaseCustomer::class, 'customer_id');
    }
}