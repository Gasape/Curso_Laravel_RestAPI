<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;


class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compradores = Buyer::has('transactions')->get();

        return $this->showAll($compradores);
    }

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        $comprador = Buyer::has('transactions')->findOrFail($buyer);

        return $this->showOne($comprador);

    }
}
