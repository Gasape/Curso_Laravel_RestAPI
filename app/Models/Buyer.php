<?php

namespace App\Models;

use App\Http\Resources\Buyer as BuyerResources;
use App\Http\Resources\BuyerCollection;
use App\Models\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends User
{
    use HasFactory;

    public $transformResource  = BuyerResources::class;
    public $transformCollection  = BuyerCollection::class; 

    protected static function boot(){
        Parent::boot();

        static::addGlobalScope(new BuyerScope);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
