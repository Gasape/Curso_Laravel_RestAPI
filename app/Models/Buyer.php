<?php

namespace App\Models;

use App\Models\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends User
{
    use HasFactory;

    protected static function boot(){
        Parent::boot();

        static::addGlobalScope(new BuyerScope);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
