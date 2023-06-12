<?php

namespace Rondigital\Auth;

use CerenOzkurt\ResponseMessages\ResponseTrait;
use Illuminate\Support\Facades\Http;

class AuthService
{
    use ResponseTrait;
    protected $authUrl;
    protected $project;
    public function __construct($projectName = 'default')
    {
        $this->authUrl = "https:/auth.ronservice.co";
        $this->project =  $projectName;
    }
    public function login($userName, $password)
    {
        $loginResponse = Http::post($this->authUrl . "/login?project=" . $this->project, [
            'username' => $userName,
            'password' => $password
        ]);
        if ($loginResponse->getStatusCode() != 200) {
            $errorData = json_decode($loginResponse, true);
            if ($errorData['validation_error']) {
                return $this->responseValidation($errorData['validation_error'], $loginResponse->getStatusCode());
            }
            return $this->responseError($errorData['error'], $loginResponse->getStatusCode());
        }
        $responseData = json_decode($loginResponse->body(), true);
        return $this->responseData($responseData['data'], $responseData['message']);
    }

    public function register(
        $password,
        $email = null,
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

        $registerResponse = Http::post($this->authUrl . "/register?project=" . $this->project, $query);
        if ($registerResponse->getStatusCode() != 200) {
            $errorData = json_decode($registerResponse, true);
            if ($errorData['validation_error']) {
                return $this->responseValidation($errorData['validation_error'], $registerResponse->getStatusCode());
            }
            return $this->responseError($errorData['error'], $registerResponse->getStatusCode());
        }
        $responseData = json_decode($registerResponse->body(), true);
        return $this->responseData($responseData['data'], $responseData['message']);
    }

    public function logout($bearerToken)
    {
        $logoutResponse = Http::withHeaders(['authorization' => $bearerToken])->get($this->authUrl . "/logout");
        if ($logoutResponse->getStatusCode() != 200) {
            $errorData = json_decode($logoutResponse, true);
            if ($errorData['validation_error']) {
                return $this->responseValidation($errorData['validation_error'], $logoutResponse->getStatusCode());
            }
            return $this->responseError($errorData['error'], $logoutResponse->getStatusCode());
        }
        $responseData = json_decode($logoutResponse->body(), true);
        return $this->responseSuccess($responseData['message']);
    }

    public function auth($bearerToken)
    {
        $authResponse = Http::withHeaders(['content-type' => 'application/json', 'Authorization' => $bearerToken])->get($this->authUrl . "/auth-user");
        if ($authResponse->getStatusCode() != 200) {
            $errorData = json_decode($authResponse, true);
            if ($errorData['validation_error']) {
                return $this->responseValidation($errorData['validation_error'], $authResponse->getStatusCode());
            }
            return $this->responseError($errorData['error'], $authResponse->getStatusCode());
        }
        $responseData = json_decode($authResponse->body(), true);
        return $this->responseData($responseData['data']);
    }

    public function resetPassword($email)
    {
        $resetPasswordResponse = Http::post($this->authUrl . "/reset-password?project=" . $this->project, [
            'email' => $email
        ]);
        if ($resetPasswordResponse->getStatusCode() != 200) {
            $errorData = json_decode($resetPasswordResponse, true);
            if ($errorData['validation_error']) {
                return $this->responseValidation($errorData['validation_error'], $resetPasswordResponse->getStatusCode());
            }
            return $this->responseError($errorData['error'], $resetPasswordResponse->getStatusCode());
        }
        $responseData = json_decode($resetPasswordResponse->body(), true);
        return $this->responseSuccess($responseData['message']);
    }

    public function update(
        $bearerToken,
        $password = null,
        // $email = null,
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
        $query = [];

        if ($password) {
            $query['password'] = $password;
        }

        // if ($email) {
        //     $query['email'] = $email;
        // }

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

        $updateResponse = Http::withHeaders(['conntent-type' => 'application/json', 'Authorization' => $bearerToken])->post($this->authUrl . "/update?project=" . $this->project, $query);
        if ($updateResponse->getStatusCode() != 200) {
            $errorData = json_decode($updateResponse, true);
            if ($errorData['validation_error']) {
                return $this->responseValidation($errorData['validation_error'], $updateResponse->getStatusCode());
            }
            return $this->responseError($errorData['error'], $updateResponse->getStatusCode());
        }
        $responseData = json_decode($updateResponse->body(), true);
        return $this->responseData($responseData['data'], $responseData['message']);
    }

    public function verifyEmail($userId, $bearerToken)
    {
        $emailVerifyResponse = Http::withHeaders(['content-type' => 'application/json', 'Authorization' => $bearerToken])->post($this->authUrl . "/verify-email?project=" . $this->project, [
            'userId' => $userId
        ]);
        if ($emailVerifyResponse->getStatusCode() != 200) {
            $errorData = json_decode($emailVerifyResponse, true);
            if ($errorData['validation_error']) {
                return $this->responseValidation($errorData['validation_error'], $emailVerifyResponse->getStatusCode());
            }
            return $this->responseError($errorData['error'], $emailVerifyResponse->getStatusCode());
        }
        $responseData = json_decode($emailVerifyResponse->body(), true);
        return $this->responseSuccess($responseData['message']);
    }
}
