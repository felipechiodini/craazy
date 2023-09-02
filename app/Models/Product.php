<?php

namespace App\Models;

use App\Cart\ActiveProduct;
use App\Utils\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'category_id',
        'active',
        'name',
        'description'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function promotion()
    {
        return $this->hasOne(ProductPrice::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function mainPhoto()
    {
        return $this->hasOne(ProductPhoto::class)
            ->orderBy('order');
    }

    public function configuration()
    {
        return $this->hasOne(ProductConfiguration::class);
    }

    public function additionals()
    {
        return $this->hasMany(ProductAdditional::class);
    }

    public function replacements()
    {
        return $this->hasMany(ProductReplacement::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCurrentPrice()
    {
        $now = now();

        $modelPrice = $this->prices()
            ->where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->first();

        if ($modelPrice === null) return null;

        $modelPromotion = $this->promotion()
            ->where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->first();

        if ($modelPromotion) {
            return Helper::calculateDiscount($modelPrice->value, $modelPromotion->value, $modelPromotion->type);
        }

        return $modelPrice->value;
    }

    public function active()
    {
        (new ActiveProduct($this))
            ->active();
    }
}
