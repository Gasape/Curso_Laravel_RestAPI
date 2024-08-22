<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;


class CategorySellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        // Obtener la lista de vendedores para una categoria especifica 
        $sellers = $category->products()->with('seller')->get()->pluck('seller')->unique()->values();

        return $this->showAll($sellers);
    }

    
}
