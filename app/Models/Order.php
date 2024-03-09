<?php

namespace App\Models;

use App\Enums\OrdePaymentMethodEnum;
use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends PrimaryModel
{
    protected $guarded = [''];
    protected $casts = [
        'status' => OrderStatusEnum::class,
        'payment_method' => OrdePaymentMethodEnum::class
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function patient(): BelongsTo
    {
        return $this->has(User::class)->through(Appointment::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
