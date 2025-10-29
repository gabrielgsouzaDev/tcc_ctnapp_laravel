<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function cadastrarAdmin(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'senha' => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'senha' => Hash::make($validated['senha']),
        ]);

        return response()->json($admin, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin || !Hash::check($request->senha, $admin->senha)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        // Aqui você pode gerar token Laravel Sanctum ou JWT
        return response()->json($admin);
    }

    public function listarAdmins()
    {
        return response()->json(Admin::all());
    }
}
