<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\putRequest;
use App\Http\Requests\User\storeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Listar de los usuarios disponibles 
        $usuarios = User::all();
        
        return $this->showAll($usuarios);

        // return $usuarios;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        // Crear un usuario
        if($request->validated()){

            $usuario = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verified' => User::Usuario_No_Verificado,
                'verification_token' => User::generarVerificationToken(),
                'admin' => User::Usuario_Regular,
            ]);
            return $this->showOne($usuario);
        }else{
            return $this->errorResponse($request->validated(), 422);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Usuario especifico
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(putRequest $request, User $user)
    {
        if($request->validated()){
            // Conseguir el usuario en cuestion //sigue aquí ya que el proyecto comenzó como un proyecto de laravel 11 y en laravel 11 solo te pasan el id 
            // No el usuario completo es por ello que para adaptarse se concidero simplemente pasarle el ID
            $usuario = User::findOrFail($user->id);
            // Crear un array vacío que llenaremos con los datos a actualizar
            $data = [];

            // Actualizar nombre si se proporciona
            if ($request->filled('name') && $usuario->name != $request->name) {
                $data['name'] = $request->name;
            }

            // Actualizar email si se proporciona
            if ($request->filled('email') && $usuario->email != $request->email) {
                $data['email'] = $request->email;
                $data['verified'] = User::Usuario_No_Verificado;
            }

            if ($request->filled('verified') && $usuario->verified != $request->verified){
                if($request->verified == 1){
                    $data['verified'] = User::Usuario_Verificado;
                }else{
                    $data['verified'] = User::Usuario_No_Verificado;

                }
            }

            // Actualizar admin si se proporciona
            if ($request->filled('admin') && $usuario->admin != $request->admin) {
                if(!$usuario->esVerificado()) {
                    return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador', 422);
                }
                $data['admin'] = $request->admin;
            }

            if($data != null){
                // Actualizar solo los campos que fueron modificados
                $usuario->update($data);
                return $this->showOne($usuario);

            }else{
                return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
            }
        }else{
            if($request->validated() == null){
                if(!$request->expectsJson()){
                    return $this->errorResponse('Se esperaba una petición JSON', 422);
                }
                return $this->errorResponse('Los datos no son validos y/o estan vacios', 422);
            }else{
                return $this->errorResponse($request->validated(), 422);
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Eliminar un usuario especifico 
        $usuario = User::findOrFail($user);
        $usuario->delete();
        return response()->json(['message' => 'Usuario Eliminado con exito'], 200);
    }
}
