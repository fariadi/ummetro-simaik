<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use App\Models\User;
use App\Services\HttpRequest;
use App\Traits\ResponseTrait;
use App\Http\Requests\authentications\RegisterStore;
use App\Http\Requests\authentications\LoginRequest;
use Validator;
use Cookie;

class AuthController extends Controller
{
  
  use ResponseTrait;

  public function tesEnv(Request $request): JsonResponse
  {
    $data = [
      'value1' => env('API_AKADEMIK_URL', 'https://akademik.ummetro.ac.idxxxx')
    ];
    return $this->responseSuccess($data, 'Logged In Successfully !');
  }

  public function index(Request $request)
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-rpl', [
      'pageConfigs' => $pageConfigs,
    ]);
  }

  public function pratinjauRegister(RegisterStore $request)
  {
    $data = [
      'ip' => $request->ip(),
      'name' => $request->name,
      'tgl_lahir' => $request->tgl_lahir,
      'tmpt_lahir' => $request->tmpt_lahir,
      'jk' => $request->jk,
      'email' => $request->email,
      'telepon_seluler' => $request->telepon_seluler,
      'jln' => $request->jln,
      'nbm' => $request->nbm ? $request->nbm : '',
      'pegawai_id' => $request->simpeg_sdm_id ? $request->simpeg_sdm_id : '',
      //'mhs_prodi_kode' => $request->mhs_prodi_kode ? $request->mhs_prodi_kode : '',
      //'mhs_prodi_nama' => $request->mhs_prodi_nama ? $request->mhs_prodi_nama : '',
    ];
    return response()->json(
      [
        'message' => 'Successfully created user!',
        'data' => $data,
      ],
      201
    );
  }

  public function register(RegisterStore $request)
  {
    $agent = new Agent();
    $jwt = new HttpRequest();

    $browser = $agent->browser();
    $version = $agent->version($browser);
    $platform = $agent->platform();
    $version = $agent->version($platform);

    $user = new User($request->all());

    if ($user->save()) {
      try {
        /**
         * Add User to Group
         */
        $groups = ['users_id' => $user->id, 'roles_id' => 2];
        $groupCreate = \App\Models\UserRoles::create($groups);

        if($request->input('pegawai_id')) {
          $pegawalValue = [
            'id' => $request->input('pegawai_id'),
            'user_id' => $user->id,
            'nama_lengkap' => $request->input('name'),
            'nbm' => $request->input('nbm')
          ];

          \App\Models\Pegawai\PegawaiModel::create($pegawalValue);
        }
        /** End */
      } catch (\Exception $e) {
        /**
         * Delete user is error group
         */
        $user->find($user->id)->delete();
        /** End */
        return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }

      /**
       * Membuat Cookie
       */
      $request->merge([
        'ip' => $request->ip(),
        'platform' => $platform,
        'version' => $version,
      ]);
      $data = $request->all();
      $userToken = $jwt->cookieRegister($data);
      Cookie::queue('form-register', $userToken, 120);
      /** End */

      return $this->responseSuccess($data, 'Ok !');
    } else {
      return $this->responseError(null, 'Data tidak valid', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function authenticate(LoginRequest $request): RedirectResponse
  {
    $credentials = $request->getCredentials();
    /*
    $credentials = $request->validate([
      'email' => ['required'],
      'password' => ['required'],
    ]);
    */

    if (Auth::attempt($credentials)) {
      if (!Auth::user()->hasAnyRole(['admin', 'peserta', 'asesor'])) {
        return back()
          ->withErrors([
            'email' => 'The provided credentials do not match our records.',
          ])
          ->onlyInput('email');
      }

      ///$request->session()->regenerate();

      $user = $request->user();
      $request->user()->update([
        'last_login' => time(),
        'ip_address' => $request->getClientIp(),
      ]);

      /**
       * Login With Administrator
       */
      if(Auth::user()->hasRole('admin')) {
        return redirect()->intended('dashboard');
      }

      /**
       * Login With Administrator
       */
      if(Auth::user()->hasRole('asesor')) {
        if(Auth::guard('peserta')->loginUsingId(Auth::user()->id)) {
          return redirect()->intended('mentor');
        };
        
      }
      
      /** End */

      /**
      * Login With Peserta
      */
      if(Auth::user()->hasRole('peserta')) {        
        if(Auth::guard('peserta')->loginUsingId(Auth::user()->id)) {
          return redirect()->intended('home');
        };
      }
      /** End */

      //return redirect()->intended('dashboard');
      /** End */
    }

    return back()
      ->withErrors([
        'email' => 'The provided credentials do not match our records.',
      ])
      ->onlyInput('email');
  }

  public function loginAsPeserta(Request $request): RedirectResponse
  {
    $credentials = $request->validate([
      'id' => ['required'],
    ]);

    if (Auth::guard('peserta')->loginUsingId($credentials['id'])) {
      if (
        !Auth::guard('peserta')
          ->user()
          ->hasAnyRole(['peserta'])
      ) {
        return back()
          ->withErrors([
            'peserta' => 'The provided credentials do not match our records.',
          ])
          ->onlyInput('peserta');
      }

      return redirect()->intended('home');
    }

    return back()
      ->withErrors([
        'peserta' => 'The provided credentials do not match our records.',
      ])
      ->onlyInput('peserta');
  }

  public function sendMailForget(Request $request)
  {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
      ? back()->with(['status' => __($status)])
      : back()->withErrors(['email' => __($status)]);
  }

  /**
   * Write code on Method
   * @return response()
   *
   */
  public function showResetPasswordForm($token)
  {
    return view('auth.forgetPasswordLink', ['token' => $token]);
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  public function resetPassword(Request $request)
  {
    $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function (
      User $user,
      string $password
    ) {
      $user
        ->forceFill([
          'password' => Hash::make($password),
        ])
        ->setRememberToken(Str::random(60));

      $user->save();
    });

    return $status === Password::PASSWORD_RESET
      ? redirect()
        ->route('auth-login')
        ->with('status', __($status))
      : back()->withErrors(['email' => [__($status)]]);
  }

  public function resetPasswordPeserta(Request $request)
  {
        # Validation
        $request->validate([
            'new_password' => 'required|same:confirm_new_password',
        ]);

        #Match The Old Password
        /*
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }
        */

        #Update the new Password
        try {
            User::whereId(Auth::guard('peserta')->user()->id)->update([
                'password' => bcrypt($request->new_password) /* Hash::make($request->new_password) */
            ]);

            return $this->responseSuccess($request->all(), 'Successfully !');
        }
        catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
  }

  
  public function logout(Request $request)
  {
    Auth::logout();
    Auth::guard('peserta')->logout();
    request()
      ->session()
      ->invalidate();
    request()
      ->session()
      ->regenerateToken();

    return redirect('/auth/login');
  }
}
