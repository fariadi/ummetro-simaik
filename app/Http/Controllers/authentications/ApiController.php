<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\authentications\LoginRequest;
use App\Services\HttpSimpeg;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
  /**
   * Response trait to handle return responses.
   */
  use ResponseTrait;

  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'register', 'simpegAuth']]);
  }

  /**
   * @OA\POST(
   *     path="/api/auth/login",
   *     tags={"Authentication"},
   *     summary="Login",
   *     description="Login",
   *     @OA\RequestBody(
   *          @OA\JsonContent(
   *              type="object",
   *              @OA\Property(property="email", type="string", example="admin@example.com"),
   *              @OA\Property(property="password", type="string", example="123456")
   *          ),
   *      ),
   *      @OA\Response(response=200, description="Login"),
   *      @OA\Response(response=400, description="Bad request"),
   *      @OA\Response(response=404, description="Resource Not Found")
   * )
   */

  public function login(LoginRequest $request): JsonResponse
  {
    try {
      $credentials = $request->only('username', 'password');

      if ($token = $this->guard()->attempt($credentials)) {
        $role = ['pustik'];
        if (
          !Auth::guard('api')
            ->user()
            ->hasAnyRole($role)
        ) {
          return $this->responseError(null, 'Un Authenticated Access', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $data = $this->respondWithToken($token);
      } else {
        return $this->responseError(null, 'Invalid Email and Password !', Response::HTTP_UNAUTHORIZED);
      }

      return $this->responseSuccess($data, 'Logged In Successfully !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\GET(
   *     path="/api/auth/me",
   *     tags={"Authentication"},
   *     summary="Authenticated User Profile",
   *     description="Authenticated User Profile",
   *     security={{"bearer":{}}},
   *     @OA\Response(response=200, description="Authenticated User Profile" ),
   *     @OA\Response(response=400, description="Bad request"),
   *     @OA\Response(response=404, description="Resource Not Found"),
   * )
   */
  public function me(): JsonResponse
  {
    try {
      $data = $this->guard()->user();
      return $this->responseSuccess($data, 'Profile Fetched Successfully !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


  /**
   * @OA\POST(
   *     path="/api/auth/logout",
   *     tags={"Authentication"},
   *     summary="Logout",
   *     description="Logout",
   *     @OA\Response(response=200, description="Logout" ),
   *     @OA\Response(response=400, description="Bad request"),
   *     @OA\Response(response=404, description="Resource Not Found"),
   * )
   */
  public function logout(): JsonResponse
  {
    try {
      $this->guard()->logout();
      return $this->responseSuccess(null, 'Logged out successfully !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @OA\POST(
   *     path="/api/auth/refresh",
   *     tags={"Authentication"},
   *     summary="Refresh",
   *     description="Refresh",
   *     security={{"bearer":{}}},
   *     @OA\Response(response=200, description="Refresh" ),
   *     @OA\Response(response=400, description="Bad request"),
   *     @OA\Response(response=404, description="Resource Not Found"),
   * )
   */
  public function refresh(): JsonResponse
  {
    try {
      $data = $this->respondWithToken($this->guard()->refresh());
      return $this->responseSuccess($data, 'Token Refreshed Successfully !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */

  protected function respondWithToken($token): array
  {
    $data = [
      [
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' =>
          $this->guard()
            ->factory()
            ->getTTL() *
          60 *
          24 *
          30, // 43200 Minutes = 30 Days
        'user' => $this->guard()->user(),
        'role' => auth('api')
          ->user()
          ->hasRole('pustik')
          ? 'pustik'
          : '',
      ],
    ];
    return $data[0];
  }

  /*
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
    */

  /**
   * Get the guard to be used during authentication.
   *
   * @return \Illuminate\Contracts\Auth\Guard
   */

  public function guard(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
  {
    return Auth::guard('api');
  }

  public function simpegAuth(LoginRequest $request): JsonResponse
  {
    $httpSimpeg = new HttpSimpeg();
    $tokenSimpeg = $httpSimpeg->token();
    try {
      $credentials = $request->only('username', 'password');
      $apiUrl = env('API_SIMPEG_URL', 'https://simpeg.ummetro.ac.id/');

      $response = Http::withHeaders([
        'Accept' => '*/*'
      ])->post($apiUrl . 'api/login/check', $credentials);

      if ($response->status() !== 200) {
        return $this->responseError($response->body(), 'Akun SIMPEG tidak terdaftar!.', Response::HTTP_INTERNAL_SERVER_ERROR);
      }

      $body = json_decode($response->body());
      $data = isset($body->user) ? $body->user : [];
      if (empty($data)) {
        return $this->responseError(null, 'Biodata SIMPEG tidak ditemukan!.', Response::HTTP_INTERNAL_SERVER_ERROR);
      }
      return $this->responseSuccess($data, 'Logged In Successfully !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
