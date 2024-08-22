<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;


class TransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transacciones = Transaction::all();
        // Todas las transferencias
        return $this->showAll($transacciones);

    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Una transferencia especifica
        return $this->showOne($transaction);
    }

}
