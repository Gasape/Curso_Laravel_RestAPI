<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendedores = Seller::has('products')->get();

        return $this->showAll($vendedores);
    }


    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        $vendedor = Seller::has('products')->findOrFail($seller);

        return $this->showOne($vendedor);
    }
}
    