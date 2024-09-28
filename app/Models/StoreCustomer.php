<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'document',
        'cellphone'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where((new static())->getTable() . '.store_id', app('currentTenant')->id);
        });
    }

}
