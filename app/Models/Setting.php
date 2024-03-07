<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class Setting extends PrimaryModel
{
    use HasFactory;
    protected $guarded = [""];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, "imagable");
    }
}
