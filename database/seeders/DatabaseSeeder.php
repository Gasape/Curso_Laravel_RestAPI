<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        $cantidadUsuarios = 1000;
        $cantidadCategories = 40;
        $cantidadProductos = 1000;
        $cantidadTransacciones = 1000;

        User::factory()->count($cantidadUsuarios)->create();
        Category::factory()->count($cantidadCategories)->create();
        Product::factory()->count($cantidadProductos)->create()->each(
            function ($producto) {
                $categorias = Category::inRandomOrder()->limit(mt_rand(1, 5))->pluck('id');

                $producto->categories()->attach($categorias);
            }
        );
        Transaction::factory()->count($cantidadTransacciones)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
