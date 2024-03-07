<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slide extends PrimaryModel
{
    use HasFactory;
    protected $guarded = [""];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "on_home" => "boolean",
        "active" => "boolean",
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
