<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'titulo' => (string)$this->name,
            'detalles' => (string)$this->description,
            'cantidad' => (integer)$this->quantity,
            'estado' => (bool)$this->status,
            'imagen' => url("img/{$this->image}"),
            'vendedor' => (int)$this->seller_id,
            'fechaCreación' => $this->created_at->format('Y-m-d H:i:s'),
            'fechaActualización' => $this->updated_at->format('Y-m-d H:i:s'),
            'fechaEliminacion' =>  $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            'links' => [
                [
                    'rel' => 'self',
                    'self' => route('products.show', $this->id),
                ],
                [
                    'rel' => 'product.buyers',
                    'self' => route('products.buyers.index', $this->id),
                ],
                [
                    'rel' => 'product.categories',
                    'self' => route('products.categories.index', $this->id),
                ],
                [
                    'rel' => 'product.transactions',
                    'self' => route('products.transactions.index', $this->id),
                ],
                [
                    'rel' => 'seller',
                    'self' => route('sellers.show', $this->seller_id),
                ],
            ],
        ];
    }
}
