<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Prescription extends PrimaryModel
{
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicine');
    }
}
