<?php

namespace App\Models;

class Image extends PrimaryModel
{
    protected $guarded = [""];

    public function imagable()
    {
        return $this->morphTo();
    }
}
