<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slot extends PrimaryModel
{
    use HasFactory;

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belolngsTo(User::class);
    }
}
