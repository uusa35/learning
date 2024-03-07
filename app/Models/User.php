<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
        'has_file' => 'boolean'
    ];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
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

    public function pateint_appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patinet_id');
    }

    public function doctor_appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function creator_appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'created_by');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
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
        return $this->hasRole('Patient') && !is_null($this->signature);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }
}
