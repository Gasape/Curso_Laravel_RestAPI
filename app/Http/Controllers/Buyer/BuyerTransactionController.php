<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        //Mostrar comprador de una transacción especifica 
        $transactions = $buyer->transactions;

        return $this->showAll($transactions);
    }

}
