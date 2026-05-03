<?php

namespace App\Modules\Auth\Controllers; // here we are defining the namespace for the AuthController class which is App\Modules\Auth\Controllers.
//  it defines the location of the class in the application structure and helps to organize the code in a modular way. it also allows us to use the class without having to specify the full namespace every time we want to use it.
use App\Http\Controllers\Controller;
use App\Modules\Auth\Services\AuthService;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\DTOs\RegisterDTO;
use App\Modules\Auth\DTOs\LoginDTO; 
use Illuminate\Http\Request; // here we are importing the Request class from the Illuminate\Http namespace to use it in the logout and me methods.

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {} // here we are defining the constructor for the AuthController class and using dependency injection to inject the AuthService class into it. this allows us to use the AuthService class in the methods of the AuthController class without having to create an instance of it every time.

    public function register(RegisterRequest $request) // define function to call from route and use RegisterRequest for validation $request is a payload .
    {
    $validated = $request->validated(); // here we are validating the request and getting the validated data in $validated variable.
    $dto = RegisterDTO::fromRequest((object) $validated); // here we are creating a DTO object from the validated .
    return $this->authService->register($dto); // here we are calling the register method of the AuthService and passing the DTO object to it and returning the response.
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $dto = LoginDTO::fromRequest($request);
        return $this->authService->login($dto);
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request->user());
    }

    public function me(Request $request)
    {
        return $this->authService->me($request->user());
    }
}