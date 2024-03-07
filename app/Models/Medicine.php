<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Medicine extends PrimaryModel
{

    public function prescription(): BelongsToMany
    {
        return $this->belongsToMany(Prescription::class, 'prescription_medicine');
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, "categoryable");
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
