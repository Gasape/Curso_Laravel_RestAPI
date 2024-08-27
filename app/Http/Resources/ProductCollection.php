<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function($product) use ($request) {
                return (new Product($product))->toArray($request);
            }),
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'titulo' => 'name',
            'detalles' => 'description',
            'cantidad' => 'quantity',
            'estado' => 'status',
            'imagen' => 'image',
            'vendedor' => 'seller_id',
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
             'name' => 'titulo',
             'description' => 'detalles',
             'quantity' => 'cantidad',
             'status' => 'estado',
             'image' => 'imagen',
             'seller_id' => 'vendedor',
             'created_at' => 'fechaCreación',
             'updated_at' => 'fechaActualización',
             'deleted_at' => 'fechaEliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
