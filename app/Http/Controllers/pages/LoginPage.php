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


class LoginPage extends Controller
{
    public function index(Request $request)
    {
        /*
        Cookie::queue(
            Cookie::forget('form-register')
        );
        */
        return view('content.authentications.auth-login', [
            'pageConfigs' => ['myLayout' => 'blank']
        ]);
    }

    public function forgot(Request $request)
    {
        /*
        Cookie::queue(
            Cookie::forget('form-register')
        );
        */
        return view('content.authentications.auth-forgot-rpl', [
            'pageConfigs' => ['myLayout' => 'blank']
        ]);
    }
}