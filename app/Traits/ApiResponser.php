<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($errors, $code)
    {
        return response()->json(['error' => $errors, 'code' => $code], $code);
    }
    
    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        if($collection->isEmpty()){
            return $this->successResponse(['data' =>$collection], $code);
        }

        $transformer = $collection->first()->transformCollection;

        // $collection = $this->transformData($collection, $transformer);
        // return $this->successResponse(['data' => $collection], $code);
        return new $transformer($collection); //new UserCollection($users);
    }

    protected function showOne(Model $model, $code = 200)
    {
        $transformer = $model->transformResource;
        // return $this->successResponse(['data' => $model], $code);
        return new $transformer($model); // new UserResource($users);
    }
}
