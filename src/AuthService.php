<?php

namespace Rondigital\Auth;

use Illuminate\Support\Facades\Http;

class AuthService
{
    protected $authUrl;
    protected $project;
    public function __construct()
    {
        $this->authUrl = "https://auth.ronservice.co";
        $this->project = $this->app['config']->get('authservice.project_name');
    }
    public function login($userName, $password)
    {
        $loginResponse = Http::post($this->authUrl . "/login?project=" . $this->project, [
            'username' => $userName,
            'password' => $password
        ]);
        if ($loginResponse->getStatusCode() != 200) {
            return $loginResponse->json();
        }
        $responseData = json_decode($loginResponse->body(), true);
        return $responseData;
    }
}
