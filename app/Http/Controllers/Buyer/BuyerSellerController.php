<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        // Todos los compradores que le han comprado a un vendedor
        $vendedores = $buyer->transactions()->with('product.seller')->get()->pluck('product.seller')->unique('id')->values();

        return $this->showAll($vendedores);
    }

   
}
