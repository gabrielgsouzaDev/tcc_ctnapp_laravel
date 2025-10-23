<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function cadastrarAdmin(Request $request)
    {
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email|unique:admins,email',
            'senha'=>'required|min:6'
        ]);

        $admin = Admin::create([
            'nome'=>$request->nome,
            'email'=>$request->email,
            'senha_hash'=>bcrypt($request->senha)
        ]);

        return response()->json(['sucesso'=>true, 'admin'=>$admin]);
    }

    public function listarAdmins()
    {
        $admins = Admin::all();
        return response()->json($admins);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'senha'=>'required'
        ]);

        $admin = Admin::where('email',$request->email)->first();
        if(!$admin || !password_verify($request->senha, $admin->senha_hash)){
            return response()->json(['erro'=>'Credenciais inválidas'], 401);
        }

        return response()->json(['sucesso'=>true, 'admin'=>$admin]);
    }
}
