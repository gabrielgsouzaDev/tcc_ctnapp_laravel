<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials'));
        $this->auth = $factory->createAuth();
    }

    public function verifyToken($idToken)
    {
        return $this->auth->verifyIdToken($idToken);
    }

    public function createUser($email, $senha, $nome)
    {
        return $this->auth->createUser([
            'email' => $email,
            'password' => $senha,
            'displayName' => $nome
        ]);
    }
}
