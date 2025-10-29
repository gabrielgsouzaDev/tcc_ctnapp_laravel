<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Auth;

class FirebaseAuth
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Token não fornecido'], 401);
        }

        $idToken = substr($authHeader, 7);

        $verified = $this->firebase->verifyToken($idToken);

        if (!$verified) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        $uid = $verified->claims()->get('sub');
        $role = $verified->claims()->get('role'); // <- se quiser armazenar no Firebase o tipo de usuário

        // Anexa o UID e role ao request
        $request->merge([
            'firebase_uid' => $uid,
            'user_role' => $role ?? 'user',
        ]);

        return $next($request);
    }
}
