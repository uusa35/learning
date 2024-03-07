<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends PrimaryModel
{
    use SoftDeletes;
    protected $guarded = [""];
    protected $casts = [
        "on_home" => "boolean",
        "on_new" => "boolean",
        "is_featured" => "boolean",
        "is_parent" => "boolean",
        "is_searchable" => "boolean",
        "order" => "integer",
        "active" => "boolean",
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "created_at",
        "updated_at",
        "delated_at",
    ];

    /**
     * * ParentCategory
     * reverse
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, "parent_id");
    }

    /**
     * * ChildCategory
     * hasMany
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, "parent_id");
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, "categoryable");
    }

    public function medicenes(): MorphToMany
    {
        return $this->morphedByMany(Medicine::class, "categoryable");
    }

    public function scopeOnlyParent($q): void
    {
        $q->where("parent_id", 0);
    }

    public function scopeOnlyChildren($q): void
    {
        $q->where("parent_id", "!=", 0);
    }

    public function scopeOnlySearchable($q): void
    {
        $q->where("is_searchable", true);
    }


    public function scopeOnlyForUsers($q): void
    {
        $q->where("is_user", true);
    }

    public function getIsParentAttribute(): Bool
    {
        return $this->parent_id === 0;
    }
}
