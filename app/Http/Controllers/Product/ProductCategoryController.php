<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        // Todas las categorias de un producto 
        $categories = $product->categories;

        return $this->showAll($categories);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, Category $category)
    {
        // Añade la categoría de un producto especifico
        // Sync, attach, syncWithoutDetaching
        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Category $category)
    {
        // Eliminar la categoría de un producto especifico
        if(!$product->categories()->find($category->id)){
            return $this->errorResponse('La categoría especificada no es una categoría de este producto',404); 
        }

        $product->categories()->detach([$category->id]);

        return $this->showAll($product->categories);
    }
}
