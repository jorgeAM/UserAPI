<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $usuarios = User::all();
      return response()->json(['usuarios' => $usuarios]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
      ]);
      $data = $request->all();
      $data['password'] = bcrypt($request->password);
      $usuario = User::create($data);
      return response()->json(['usuario' => $usuario]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
      return response()->json(['usuario' => $usuario]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
      $this->validate($request, [
        'name' => 'min:4',
        'email' => 'email|unique:users',
        'password' => 'min:6'
      ]);
      $usuario->fill($request->all());
      if($usuario->isClean()){
        return response()->json(['error' => 'Hubo un error']);
      }
      $usuario->save();
      return response()->json(['usuario' => $usuario]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
      $usuario->delete();
      return response()->json(['usuario eliminado' => $usuario]);
    }
}
