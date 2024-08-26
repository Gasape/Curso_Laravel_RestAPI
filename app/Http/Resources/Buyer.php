<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Buyer extends JsonResource
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
            'nombre' => (string)$this->name,
            'correo' => (string)$this->email,
            'esVerificado' => (integer)$this->verified,
            'fechaCreación' => $this->created_at->format('Y-m-d H:i:s'),
            'fechaActualización' => $this->updated_at->format('Y-m-d H:i:s'),
            'fechaEliminacion' =>  $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            'links' => [
                [
                    'rel' => 'self',
                    'self' => route('buyers.show', $this->id),
                ],
                [
                    'rel' => 'buyer.categories',
                    'self' => route('buyers.categories.index', $this->id),
                ],
                [
                    'rel' => 'buyer.products',
                    'self' => route('buyers.products.index', $this->id),
                ],
                [
                    'rel' => 'buyer.seller',
                    'self' => route('buyers.sellers.index', $this->id),
                ],
                [
                    'rel' => 'buyer.transactions',
                    'self' => route('buyers.transactions.index', $this->id),
                ],
                [
                    'rel' => 'user',
                    'self' => route('users.show', $this->id),
                ],
            ],
        ];
    }
}
