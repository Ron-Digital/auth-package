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

class AuthMiddleware
{
    use ResponseTrait;

    public function handle(Request $request, Closure $next)
    {
        $token =  $request->header('Authorization');
        if (!$token) {
            return $this->responseDataNotFound('access token');
        }

        $authResponse = Http::withHeaders(['content-type' => 'application/json', 'Authorization' => $token])->get("https://auth.ronservice.co/auth-user");
        if ($authResponse->getStatusCode() != 200) {
            return $authResponse->json();
        }
        // $data = json_decode($authResponse, true);
        // $user = [
        //     'id' => $data['data']['user']['id'],
        //     'email' => $data['data']['user']['email'],
        //     'firstName' =>  $data['data']['user']['givenName'],
        //     'lastName' =>  $data['data']['user']['familyName'],
        //     'emailVerified' =>  $data['data']['user']['emailVerified']
        // ];
        $request->merge(['user' => $authResponse->json()]);
        return $next($request);
    }
}
