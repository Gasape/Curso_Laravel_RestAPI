<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vendedores = Seller::has('products')->inRandomOrder()->get();
        $vendedoresIDs = $vendedores->pluck('id')->toArray();
        
        // Seleccionamos comprador que no sea el vendedor
        $comprador = $vendedores->where('id', '!=', $vendedoresIDs)->first();
        
        // Seleccionamos un vendedor aleatorio
        $vendedorAleatorio = $vendedores->where('id', '!=', $comprador->id)->first();

        // Seleccionar un producto aleatorio de ese vendedor
        $productoAleatorio = $vendedorAleatorio->products()->inRandomOrder()->first();

        return [
            'quantity' => fake()->numberBetween(1,3),
            'buyer_id' => $comprador->id,
            'product_id' => $productoAleatorio->id,
        ];
    }
}
