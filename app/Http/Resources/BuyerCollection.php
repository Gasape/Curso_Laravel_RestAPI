<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BuyerCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function($buyer) use ($request) {
                return (new Buyer($buyer))->toArray($request);
            }),
           
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'nombre' => 'name',
            'correo' => 'email',
            'esVerificado' => 'verified',
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
            'name' => 'nombre', 
            'email' => 'correo', 
            'verified' => 'esVerificado', 
            'created_at' => 'fechaCreación', 
            'updated_at' => 'fechaActualización', 
            'deleted_at' => 'fechaEliminacion', 
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
