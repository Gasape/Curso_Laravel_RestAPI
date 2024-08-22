<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;


class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Transaction $transaction)
    {
        //Obtener la lista de las categorias respectiva a una transaccion especifica
        $categories = $transaction->product->categories;

        return $this->showAll($categories);
    }
}
