<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Prescription extends PrimaryModel
{
    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class);
    }
}
