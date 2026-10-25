<?php

namespace Webkul\AI\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Customer\Models\Customer as BaseCustomer;
use Webkul\Product\Models\Product as BaseProduct;

class UserInteraction extends Model
{
    /**
     * The interaction type representing a product view.
     *
     * @var string
     */
    public const INTERACTION_VIEW = 'view';

    /**
     * The interaction type representing a purchase.
     *
     * @var string
     */
    public const INTERACTION_PURCHASE = 'purchase';

    /**
     * The interaction type representing a wishlist add.
     *
     * @var string
     */
    public const INTERACTION_WISHLIST = 'wishlist';

    /**
     * The interaction type representing a cart add.
     *
     * @var string
     */
    public const INTERACTION_CART = 'cart';

    /**
     * The interaction type representing a search.
     *
     * @var string
     */
    public const INTERACTION_SEARCH = 'search';

    /**
     * The allowed interaction types.
     *
     * @var array
     */
    public const INTERACTION_TYPES = [
        self::INTERACTION_VIEW,
        self::INTERACTION_PURCHASE,
        self::INTERACTION_WISHLIST,
        self::INTERACTION_CART,
        self::INTERACTION_SEARCH,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ai_user_interactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'session_id',
        'product_id',
        'interaction_type',
        'weight',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'weight'      => 'integer',
        'metadata'    => 'array',
        'created_at'  => 'datetime',
    ];

    /**
     * The product associated with the interaction.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(BaseProduct::class, 'product_id');
    }

    /**
     * The customer that owns the interaction.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(BaseCustomer::class, 'customer_id');
    }
}
