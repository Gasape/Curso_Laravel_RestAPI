<?php

namespace App\Models;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\Product as ProductResources;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    protected $fillable = ['name', 'description', 'quantity', 'status', 'image', 'seller_id'];
    protected $dates = ['deleted_at'];

    public $transformResource  = ProductResources::class;
    public $transformCollection  = ProductCollection::class; 

    protected $hidden = [
        'pivot'
    ];

    public function estaDisponible(){
        return $this->status == Product::PRODUCTO_DISPONIBLE;
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }
}
