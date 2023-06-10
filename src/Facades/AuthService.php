<?php

namespace Rondigital\Auth;

use Illuminate\Support\Facades\Facade;

/**
 * Class ResponseBuilder.
 */
class ResponseTrait extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'auth_service';
    }
}