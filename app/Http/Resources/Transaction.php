<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'identificador' => (integer)$this->id,
            'cantidad' => (integer)$this->quantity,
            'comprador' => (integer)$this->buyer_id,
            'producto' => (integer)$this->product_id,
            'fechaCreación' => $this->created_at->format('Y-m-d H:i:s'),
            'fechaActualización' => $this->updated_at->format('Y-m-d H:i:s'),
            'fechaEliminacion' =>  $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            'links' => [
                [
                    'rel' => 'self',
                    'self' => route('transactions.show', $this->id),
                ],
                [
                    'rel' => 'transaction.categories',
                    'self' => route('transactions.categories.index', $this->id),
                ],
                [
                    'rel' => 'transaction.seller',
                    'self' => route('transactions.sellers.index', $this->id),
                ],
                [
                    'rel' => 'buyer',
                    'self' => route('buyers.show', $this->buyer_id),
                ],
                [
                    'rel' => 'product',
                    'self' => route('products.show', $this->product_id),
                ],
            ],
        ];
    }
}
