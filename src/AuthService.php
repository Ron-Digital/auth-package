<?php

namespace Rondigital\Auth;

use Illuminate\Support\Facades\Http;

class AuthService
{
    protected $authUrl;
    protected $project;
    public function __construct($projectName)
    {
        $this->authUrl = "http:/localhost:8001";
        $this->project = \config('authservice.project_name') ?? $projectName;
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

    public function register(
        $email = null,
        $password,
        $userName = null,
        $givenName = null,
        $familyName = null,
        $name = null,
        $nickName = null,
        $picture = null,
        $userData = []
    ) {
        $details = [];
        foreach ($userData as $key => $value) {
            $details[$key] = $value;
        }
        $query = [
            'password' => $password
        ];

        if ($email) {
            $query['email'] = $email;
        }

        if ($userName) {
            $query['username'] = $userName;
        }

        if ($givenName) {
            $query['given_name'] = $givenName;
        }

        if ($familyName) {
            $query['family_name'] = $familyName;
        }

        if ($name) {
            $query['name'] = $name;
        }

        if ($nickName) {
            $query['nick_name'] = $nickName;
        }

        if ($picture) {
            $query['picture'] = $picture;
        }
        if ($details != []) {
            $query['user_data'] = $details;
        }

        // Diğer alanları buraya ekleyebilirsiniz

        $loginResponse = Http::post($this->authUrl . "/register?project=" . $this->project, $query);
        if ($loginResponse->getStatusCode() != 200) {
            return $loginResponse->json();
        }
        $responseData = json_decode($loginResponse->body(), true);
        return $responseData;
    }
}
