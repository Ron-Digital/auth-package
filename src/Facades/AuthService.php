<?php

namespace Rondigital\Auth;

use Illuminate\Support\Facades\Facade;

/**
 * Class ResponseBuilder.
 */
class AuthService extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'auth-service';
    }
}