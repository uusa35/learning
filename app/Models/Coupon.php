<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends PrimaryModel
{
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
