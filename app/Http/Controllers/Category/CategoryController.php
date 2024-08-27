<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . CategoryCollection::class)->only(['store', 'update']);
    }

    public function index()
    {
        //Todas las categorias
        $categories = Category::all();

        // Respondiendo a la petición
        return $this->showAll($categories);
    }

    public function store(Request $request)
    {
        // Reglas de validación
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        // Validando las reglas
        $this->validate($request, $rules);

        // Creando la categoria
        $category = Category::create($request->all());

        // Respondiendo a la petición  
        return $this->showOne($category,201);
    }

    
    public function show(Category $category)
    {
        // Respondiendo con la categoría especifica solicitada
        return $this->showOne($category,201);
    }

    
    public function update(Request $request, Category $category)
    {
        //
        $category->fill($request->only([
            'name',
            'description',
        ]));

        if($category->isClean()){
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar',422);
        }
        
        $category->save();
        
        return $this->showOne($category);
    }

    
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
