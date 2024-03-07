<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends PrimaryModel
{
    protected $guarded = [""];

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, "taggable");
    }

    public function medicenes(): MorphToMany
    {
        return $this->morphedByMany(Medicine::class, "taggable");
    }
}
