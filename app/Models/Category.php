<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Subscription;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'order',
        'is_active',
        'price',
        'price_annual',
        'asaas_plan_id',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'price'        => 'decimal:2',
        'price_annual' => 'decimal:2',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class)->orderBy('title');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
