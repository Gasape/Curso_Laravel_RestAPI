<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Transaction $transaction)
    {
        // Mostrar el vendedor de una transacción especifica, esto se logra gracias a product quien es el que tiene la relación 
        // Con el vendedor
        $seller = $transaction->product->seller;

        return $this->showOne($seller);
    }

}
