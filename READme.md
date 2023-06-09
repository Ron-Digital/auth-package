# AuthService paketi


<br>

### Gereklilikler
<br>

- *composer.json* dosyasına aşağıdaki kodu ekleyin
    ```php
    "require" : {
        "rondigital/auth": "dev-main"
    }
    "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/Ron-Digital/auth-package"
            }
        ],
    ```
 <br> 

- konsolda *composer update* komutunu çalıştırın
    ```php
    composer update
    ```

<br>

- env dosyanıza projenizin adını ekleyin
    ```php
    AUTH_SERVICE_PROJECT_NAME={{project_name}}
    ```
    <br>

- auth middleware'ini dahil edin
  
    Laravel'de app/Http/Kernel.php
    ```php
            protected $routeMiddleware = [
            'auth' => \Rondigital\Auth\Middleware\AuthMiddleware::class,
        ]
    ```
    Lumen'de bootstrap/app.php
    ```php
        $app->routeMiddleware([
            'auth' => \Rondigital\Auth\Middleware\AuthMiddleware::class,
        ]);
    ```
<br>

- route'lara da aşağıdaki gibi dahil edebilirsiniz
  
  Lumende routes/web.php
  ```php
        $router->get('/logout', ['middleware' => ['auth'], 'uses' => 'AuthController@logout']);
  ```
  Laravel'de routes/api.php
  ```php
    Route::post('/auth/login', 'login')->middleware(['auth']);
  ```
  auth middleware'ini tanımladığınız route'larda kullanıcıya aşağıdaki gibi ulaşabilirsiniz
  ```php
    $request->user
  ```
<br>

- Aşağıdaki komutta örnek kullanım mevcuttur;
```php
$authService = new AuthService(env("AUTH_SERVICE_PROJECT_NAME"));
$login = $authService->login($request->email, $request->password);
```
  
<br>
<br>
<hr>
<br>
<details>
<summary>register</summary> 

- **params** 
    - *password* : **required**
    - *email* : string | email formatı | default : null
    - *userName* : string | default : null
    - *givenName* : string | kullanıcı adı | default : null
	- *familyName* : string | kullanıcı soyadı | default : null
	- *name* : string | default : null
	- *nickname* : string | kullanıcı takma adı | default : null
	- *picture* : url | profil resmi linki | default : null
	- *userData* : array | max 10 | key-value'si özelleştirilebilir 
  

- **request** 
```php
        
        $register = $authService->register(
            $request->password,
            $request->email,
            null,
            $request->firstName,
            $request->lastName,
            null,
            null,
            null,
            [
                'organization' => $request->organization
            ]
        );
```
- **response**
```php
{
    "result": true,
    "message": "successfully registered.",
    "data": {
        "user": {
            "id": "auth0|6482fd06f170bfdfbb84b239",
            "givenName": "Ceren",
            "familyName": "Özkurt",
            "name": null,
            "nickname": null,
            "picture": null,
            "emailVerified": false,
            "email": "ceren@ron.digital",
            "username": null,
            "details": [
                {
                    "organization": "Ron Digital"
                }
            ]
        },
        "token": {
            "code": "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6InlleFZTczhfclJOeEp5X3JUYk11cCJ9.eyJpc3MiOiJodHRwczovL3Jvbi1nYXRld2F5LWFwaS51cy5hdXRoMC5jb20vIiwic3ViIjoiYXV0aDB8NjQ4MmZkMDZmMTcwYmZkZmJiODRiMjM5IiwiYXVkIjpbImh0dHBzOi8vcm9uLWdhdGV3YXktYXBpLnVzLmF1dGgwLmNvbS9hcGkvdjIvIiwiaHR0cHM6Ly9yb24tZ2F0ZXdheS1hcGkudXMuYXV0aDAuY29tL3VzZXJpbmZvIl0sImlhdCI6MTY4NjMwNjA1NCwiZXhwIjoxNjg4ODk4MDU0LCJhenAiOiJoaHh6WkhuQkFrd25tRWtRZGJVVndsbExFVUhTdzNpaCIsInNjb3BlIjoib3BlbmlkIHByb2ZpbGUgZW1haWwgcmVhZDpjdXJyZW50X3VzZXIgdXBkYXRlOmN1cnJlbnRfdXNlcl9tZXRhZGF0YSBkZWxldGU6Y3VycmVudF91c2VyX21ldGFkYXRhIGNyZWF0ZTpjdXJyZW50X3VzZXJfbWV0YWRhdGEgY3JlYXRlOmN1cnJlbnRfdXNlcl9kZXZpY2VfY3JlZGVudGlhbHMgZGVsZXRlOmN1cnJlbnRfdXNlcl9kZXZpY2VfY3JlZGVudGlhbHMgdXBkYXRlOmN1cnJlbnRfdXNlcl9pZGVudGl0aWVzIG9mZmxpbmVfYWNjZXNzIiwiZ3R5IjoicGFzc3dvcmQifQ.oRtvoD1p3klnT5Y87o1DIRnpQBUYPiE0MVSUhH_IBm9dB_un6YgH9cYIWeLgCkLjZnt2efP4YL3C-YWzyb3m3RXUlTx_bxTvAFDsR7RBunkNr3dSq-LUcuwXmNbl-OQ0NWl7AI_IVLgFOirMVzqUQgb4UMsDfmL_edgcGyIKI5SxbzZW1fnOpom8RpVZUGKag4CUStV1E2wEHVy-rJNrGrjuKzxkbBbTI3lKjez4RLeCJt6M7XXzQAxWXN7suxCwexx_OKKjuMyd9_F7xrDhccwXp-UPKZtOP0dnyIbN6YGOy5Dnz0z3TH5trD3IrqsqOKB8zGexI5-1WJaaUtqWYA",
            "expires_in": 1688898055
        }
    }
}
```

</details>

<br>

<details>
<summary>login</summary> 

- **params** 
	- *username* : **required** | *username* veya *email*
	- *password* : **required**, string

- **request**
```php
        $authService = new AuthService(env("AUTH_SERVICE_PROJECT_NAME"));
        $login = $authService->login($request->email, $request->password);
```
- **response**
```php
{
    "result": true,
    "message": "successfully logined.",
    "data": {
        "user": {
            "id": "auth0|6482fd06f170bfdfbb84b239",
            "givenName": "Ceren",
            "familyName": "Özkurt",
            "name": null,
            "nickname": null,
            "picture": null,
            "emailVerified": false,
            "email": "ceren@ron.digital",
            "username": null,
            "details": [
                {
                    "organization": "Ron Digital"
                }
            ]
        },
        "token": {
            "code": "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6InlleFZTczhfclJOeEp5X3JUYk11cCJ9.eyJpc3MiOiJodHRwczovL3Jvbi1nYXRld2F5LWFwaS51cy5hdXRoMC5jb20vIiwic3ViIjoiYXV0aDB8NjQ4MmZkMDZmMTcwYmZkZmJiODRiMjM5IiwiYXVkIjpbImh0dHBzOi8vcm9uLWdhdGV3YXktYXBpLnVzLmF1dGgwLmNvbS9hcGkvdjIvIiwiaHR0cHM6Ly9yb24tZ2F0ZXdheS1hcGkudXMuYXV0aDAuY29tL3VzZXJpbmZvIl0sImlhdCI6MTY4NjMwNjA1NCwiZXhwIjoxNjg4ODk4MDU0LCJhenAiOiJoaHh6WkhuQkFrd25tRWtRZGJVVndsbExFVUhTdzNpaCIsInNjb3BlIjoib3BlbmlkIHByb2ZpbGUgZW1haWwgcmVhZDpjdXJyZW50X3VzZXIgdXBkYXRlOmN1cnJlbnRfdXNlcl9tZXRhZGF0YSBkZWxldGU6Y3VycmVudF91c2VyX21ldGFkYXRhIGNyZWF0ZTpjdXJyZW50X3VzZXJfbWV0YWRhdGEgY3JlYXRlOmN1cnJlbnRfdXNlcl9kZXZpY2VfY3JlZGVudGlhbHMgZGVsZXRlOmN1cnJlbnRfdXNlcl9kZXZpY2VfY3JlZGVudGlhbHMgdXBkYXRlOmN1cnJlbnRfdXNlcl9pZGVudGl0aWVzIG9mZmxpbmVfYWNjZXNzIiwiZ3R5IjoicGFzc3dvcmQifQ.oRtvoD1p3klnT5Y87o1DIRnpQBUYPiE0MVSUhH_IBm9dB_un6YgH9cYIWeLgCkLjZnt2efP4YL3C-YWzyb3m3RXUlTx_bxTvAFDsR7RBunkNr3dSq-LUcuwXmNbl-OQ0NWl7AI_IVLgFOirMVzqUQgb4UMsDfmL_edgcGyIKI5SxbzZW1fnOpom8RpVZUGKag4CUStV1E2wEHVy-rJNrGrjuKzxkbBbTI3lKjez4RLeCJt6M7XXzQAxWXN7suxCwexx_OKKjuMyd9_F7xrDhccwXp-UPKZtOP0dnyIbN6YGOy5Dnz0z3TH5trD3IrqsqOKB8zGexI5-1WJaaUtqWYA",
            "expires_in": 1688898055
        }
    }
}
```
</details>

<br>

<details>
<summary>logout</summary> 

- **params** 
	- *bearerToken* : **required** | kullanıcının giriş ve kayıttan sonra gelen tokenı
- **request**
```php
    $authService = new AuthService(env("AUTH_SERVICE_PROJECT_NAME"));
    $logout = $authService->logout($request->header('Authorization'));
```
- **response**
```php
{
    "result": true,
    "message": "successfully logout."
}
```
</details>

<br>

<details>
<summary>resetPassword</summary> 

- **params** 
    - *email* = **required**

- **request**
```php
        $authService = new AuthService(env("AUTH_SERVICE_PROJECT_NAME"));
        $resetPassword = $authService->resetPassword($request->email);
```
- **response**
```php
{
    "result": true,
    "message": "password reset email sent."
}
```
</details>

<br>

<details>
<summary>verifyEmail</summary> 

- **params** :
    - *userId* : **required** | kullanıcının idsi
    - *bearerToken* : **required** | kullanıcının giriş ve kayıttan sonra gelen tokenı

- **request**
```php
        $authService = new AuthService(env("AUTH_SERVICE_PROJECT_NAME"));
        $verifyEmail = $authService->verifyEmail($user['id'], $request->header('Authorization'));
```
- **response**
 ```php
{
    "result": true,
    "message": "verification email sent successfully."
}
```

</details>

<br>

<details>
<summary>auth</summary> 

- **params** :
    - *bearerToken* : **required** | kullanıcının giriş ve kayıttan sonra gelen tokenı

- **request**
```php
        $authService = new AuthService(env("AUTH_SERVICE_PROJECT_NAME"));
        $verifyEmail = $authService->auth($request->header('Authorization'));
```
- **response**
```php
{
    "result": true,
    "data": {
        "user": {
            "id": "auth0|646b41937069b83a941fec9b",
            "givenName": "John",
            "familyName": "Deo",
            "name": "John Doe",
            "nickname": "crayz.joe",
            "picture": "https://www.image.com",
            "emailVerified": false,
            "email": "johndoe@appxapi.com",
            "username": "john.doe.16",
            "details": {
                "birthDate": "20.10.1998",
                "birthPlace": "Los Angeles",
                "address": "333 Universal Hollywood Drive, 91608, Universal City, USA",
                "phoneNumber": "4343353535",
                "gender": "male",
                "locale": "en-US",
                "timezone": "-7",
                "website": "www.crayz-john.co",
                "bio": "Hello. I am John Doe. Welcome to my crazy world!"
            }
        }
    }
}
```
</details>

<br>

<details>
<summary>update</summary> 

- **params** :
    - *userId* : **required**
    - *bearerToken : **required**
	- *password* : string | default : null
	- *email* : string | email formatı | default : null
	- *userName* : string | default : null
	- *givenName* : string | default : null
	- *familyName* : string | default : null
	- *name* : string | default : null
	- *nickName* : string | default : null
	- *picture* : url | profil resmi linki | default : null
	- *user_data* : array | max 10 | key-value'si özelleştirilebilir | üzerine yeni de eklenebilir
- **request**
```php
        $authService = new AuthService(env("AUTH_SERVICE_PROJECT_NAME"));
        $update = $authService->update(
            $userId,
            $request->header('Authorization'),
            $request->password ?? null,
            $request->firstName ?? null,
            $request->lastName ?? null,
            null,
            $request->nickName,
            null,
            [
                'github' => "github.com/cerenozkurt"
            ]
        );
```
- **response**
```php
{
    "result": true,
    "message": "user update successful",
    "data": {
        "user": {
            "id": "auth0|6482fd06f170bfdfbb84b239",
            "givenName": "Ceren",
            "familyName": "Özkurt",
            "name": null,
            "nickname": "cerenimo",
            "picture": null,
            "emailVerified": false,
            "email": "ceren@ron.digital",
            "username": null,
            "details": [
                {
                    "organization": "Ron Digital",
                    "github": "github.com/cerenozkurt"
                }
            ]
        }
    }
}
```
</details>

