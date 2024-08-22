<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;


class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        //Mostrar los productos que ha comprado un comprador
        $productos = $buyer->transactions()->with('product')->get()->pluck('product');

        

        return $this->showAll($productos);
    }

    
}
