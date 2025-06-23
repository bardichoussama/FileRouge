<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\PkgSessionDeSuivi\Services\AuthService;
use Modules\PkgSessionDeSuivi\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = $this->authService->attemptLogin($credentials);
    
        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    
        // 🔑 Create Sanctum token
        $token = $user->createToken('login-token')->plainTextToken;
    
        if ($user->apprenant) {
            return response()->json([
                'message' => 'Apprenant login successful',
                'token' => $token,
                'user' => $user
            ]);
        } elseif ($user->responsable) {
            return response()->json([
                'message' => 'Responsable login successful',
                'token' => $token,
                'user' => $user
            ]);
        }
    
        return response()->json(['error' => 'Unknown role'], 403);
    }
    

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
