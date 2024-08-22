<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;


class SellerBuyerController extends ApiController
{
    
    public function index(Seller $seller)
    {
        // Todos los usuarios a los que el vendedor ha vendido
        $buyers = $seller->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values();
        
        return $this->showAll($buyers);
    }

}
