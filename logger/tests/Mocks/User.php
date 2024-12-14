<?php

namespace Tests\Mocks;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User implements JWTSubject
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
