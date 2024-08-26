<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'fechaCreación' => $this->created_at->format('Y-m-d H:i:s'),
            'fechaActualización' => $this->updated_at->format('Y-m-d H:i:s'),
            'fechaEliminacion' =>  $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            'links' => [
                [
                    'rel' => 'self',
                    'self' => route('categories.show', $this->id),
                ],
                [
                    'rel' => 'category.buyers',
                    'self' => route('categories.buyers.index', $this->id),
                ],
                [
                    'rel' => 'category.products',
                    'self' => route('categories.products.index', $this->id),
                ],
                [
                    'rel' => 'category.sellers',
                    'self' => route('categories.sellers.index', $this->id),
                ],
                [
                    'rel' => 'category.transactions',
                    'self' => route('categories.transactions.index', $this->id),
                ], 
            ],
        ];
    }
}
