<?php

namespace App\Models;

use App\Models\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends User
{
    use HasFactory;

    protected static function boot(){
        Parent::boot();

        static::addGlobalScope(new SellerScope);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
