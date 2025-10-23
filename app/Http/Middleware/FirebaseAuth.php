<?php
namespace App\Http\Middleware;

use Closure;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

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

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return response()->json(['error' => 'Token não fornecido'], 401);
        }

        $idToken = $matches[1];
        $verifiedToken = $this->firebase->verifyIdToken($idToken);

        if (!$verifiedToken) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        // Opcional: associar usuário no banco
        $request->merge(['firebase_user_id' => $verifiedToken->claims()->get('sub')]);

        return $next($request);
    }
}
