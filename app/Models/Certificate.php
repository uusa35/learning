<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends PrimaryModel
{

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
