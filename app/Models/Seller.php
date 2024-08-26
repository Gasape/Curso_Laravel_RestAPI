<?php

namespace App\Models;

use App\Http\Resources\SellerCollection;
use App\Http\Resources\Seller as SellerResources;
use App\Models\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends User
{
    use HasFactory;

    public $transformResource  = SellerResources::class;
    public $transformCollection  = SellerCollection::class; 

    protected static function boot(){
        Parent::boot();

        static::addGlobalScope(new SellerScope);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
