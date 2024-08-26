<?php

namespace App\Models;

use App\Http\Resources\TransactionCollection;
use App\Http\Resources\Transaction as TransactionResources;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public $transformResource  = TransactionResources::class;
    public $transformCollection  = TransactionCollection::class; 

    protected $fillable = [ 'quantity', 'buyer_id', 'product_id'];
    protected $dates = ['deleted_at'];


    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
