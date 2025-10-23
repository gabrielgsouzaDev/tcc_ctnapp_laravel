<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\AuthException;

class FirebaseService
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials'));
        $this->auth = $factory->createAuth();
    }

    public function verifyToken(string $idToken)
    {
        try {
            return $this->auth->verifyIdToken($idToken);
        } catch (AuthException $e) {
            return null; // token inválido
        }
    }

    public function createUser(string $email, string $senha, string $nome)
    {
        try {
            return $this->auth->createUser([
                'email' => $email,
                'password' => $senha,
                'displayName' => $nome
            ]);
        } catch (AuthException $e) {
            return null; // erro ao criar usuário
        }
    }
}
