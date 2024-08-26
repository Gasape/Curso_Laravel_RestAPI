<?php

namespace App\Models;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\Category as CategoryResources;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public $transformResource  = CategoryResources::class;
    public $transformCollection  = CategoryCollection::class; 

    protected $hidden = [
        'pivot'
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'description'];

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
