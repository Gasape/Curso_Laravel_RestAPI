<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\putRequest;
use App\Http\Requests\User\storeRequest;
use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
            
            // Crear un array vacío que llenaremos con los datos a actualizar
            $data = [];

            // Actualizar nombre si se proporciona
            if ($request->filled('name') && $user->name != $request->name) {
                $data['name'] = $request->name;
            }

            // Actualizar email si se proporciona
            if ($request->filled('email') && $user->email != $request->email) {
                $data['email'] = $request->email;
                $data['verified'] = User::Usuario_No_Verificado;
                $data['verification_token'] = User::generarVerificationToken();
            }

            if ($request->filled('verified') && $user->verified != $request->verified){
                if($request->verified == 1){
                    $data['verified'] = User::Usuario_Verificado;
                }else{
                    $data['verified'] = User::Usuario_No_Verificado;

                }
            }

            // Actualizar admin si se proporciona
            if ($request->filled('admin') && $user->admin != $request->admin) {
                if(!$user->esVerificado()) {
                    return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador', 422);
                }
                $data['admin'] = $request->admin;
            }

            if($data != null){
                // Actualizar solo los campos que fueron modificados
                $user->update($data);
                return $this->showOne($user);

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
        $user->delete();
        return $this->showOne($user);
    }

    public function verify($token){
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::Usuario_Verificado;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('La cuenta ha sido verificada');
    }

    public function resend(User $user){
        if ($user->esVerificado()) {
            return $this->errorResponse('Este usuario ya ha sido verificado', 409);
        }

        retry(5,function() use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);

        return $this->showMessage('El correo de verificación se ha reenviado');
    }
}
