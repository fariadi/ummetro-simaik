<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use App\Models\User;
use App\Services\HttpRequest;
use Validator;
use Cookie;

class RegisterPage extends Controller
{
  public function index(Request $request)
  {
    $agent = new Agent();
    $jwt = new HttpRequest();

    try {
      $cookieRegs = Cookie::get('form-register');
      $registered = $cookieRegs ? $jwt->cookieRegisterDecode($cookieRegs) : [];
    } catch (\Exception $e) {
      $registered = [];
    }

    return view('content.authentications.auth-register', [
      'pageConfigs' => ['myLayout' => 'blank'],
      'registered' => $registered,
    ]);
  }

  public function sdm(Request $request)
  {
    $agent = new Agent();
    $jwt = new HttpRequest();

    try {
      $cookieRegs = Cookie::get('form-register');
      $registered = $cookieRegs ? $jwt->cookieRegisterDecode($cookieRegs) : [];
    } catch (\Exception $e) {
      $registered = [];
    }

    return view('content.authentications.auth-register-sdm', [
      'pageConfigs' => ['myLayout' => 'blank'],
      'registered' => $registered,
    ]);
  }

  public function clearPage(Request $request)
  {
    Cookie::queue(Cookie::forget('form-register'));
    return back()->withInput();
  }
}
