<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserBloodTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, ModelHelpers;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
        'has_file' => 'boolean',
        'blood' => UserBloodTypeEnum::class
    ];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'user_attribute');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, "imagable");
    }

    public function slots(): HasMany // only for role : Doctor
    {
        return $this->hasMany(Slot::class);
    }

    public function prescriptions(): HasMany // only for role : Paitents
    {
        return $this->hasMany(Prescription::class);
    }

    public function patient_appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patinet_id');
    }

    public function doctor_appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id', 'id');
    }

    public function creator_appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'creator_id');
    }

    public function patient_orders(): HasMany // for patient
    {
        return $this->hasMany(Order::class);
    }

    public function doctor_orders(): HasManyThrough // for doctors
    {
        return $this->through(Appointment::class)->has(Order::class);
    }

    public function createor_orders(): HasMany
    {
        return $this->hasMany(Order::class, 'creator_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, "categoryable");
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getHasSignatureAttribute(): bool
    {
        return $this->hasRole('patient') && !is_null($this->signature);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    /**
     * @param $q
     * @return \Illuminate\Database\Eloquent\Builder
     * QueryFilters used within the search
     */
    public function scopeNotAdmins($q): void
    {
        $q->whereDoesntHave("roles", fn ($q) => $q->where("name", "admin")->orWhere("name", "super"));
    }


    /**
     * @param $q
     * @return \Illuminate\Database\Eloquent\Builder
     * QueryFilters used within the search
     */
    public function scopeDoctors($q): void
    {
        $q->whereHas("roles", fn ($q) => $q->where("name", "doctor"));
    }
}
