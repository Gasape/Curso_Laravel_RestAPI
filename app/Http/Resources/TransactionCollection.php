<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'data' => $this->collection->transform(function($transaction) use ($request) {
                return (new Transaction($transaction))->toArray($request);
            }),
           
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
           'identificador' => 'id',
            'cantidad' => 'quantity',
            'comprador' => 'buyer_id',
            'producto' => 'product_id',
            'fechaCreación' => 'created_at',
            'fechaActualización' => 'updated_at',
            'fechaEliminacion' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identificador',
            'quantity' => 'cantidad',
            'buyer_id' => 'comprador',
            'product_id' => 'producto',
            'created_at' => 'fechaCreación',
            'updated_at' => 'fechaActualización',
            'deleted_at' => 'fechaEliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
