<?php

namespace Rondigital\Auth\Middleware;

use App\Http\Resources\UserResource;
use App\Models\StateToken;
use App\Services\Auth0Service;
use Closure;
use CerenOzkurt\ResponseMessages\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Rondigital\Auth\AuthService;

class AuthMiddleware
{
    use ResponseTrait;

    public function handle(Request $request, Closure $next)
    {
        $token =  $request->header('Authorization');
        if (!$token) {
            return $this->responseDataNotFound('access token');
        }
        $authService = new AuthService();
        $auth = $authService->auth($token);
        if ($auth['result'] != 'true') {
            return $auth;
        }
        $request->merge(['user' => $auth['data']['user']]);
        return $next($request);
    }
}
