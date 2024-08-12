@php
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'LOGIN')

@section('vendor-style')
<!-- Vendor -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/authentication/pages-auth.js')}}"></script>
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover authentication-bg">
  <div class="authentication-inner row">
    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 p-0">
      <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/img/illustrations/page-jumah-'.$configData['style'].'.png') }}" alt="auth-login-cover" class="img-fluid my-5 auth-illustration" data-app-light-img="illustrations/page-jumah-light.png" data-app-dark-img="illustrations/page-jumah-dark.png">

        <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}" alt="auth-login-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
      </div>
    </div>
    <!-- /Left Text -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
      <div class="w-px-400 mx-auto">
          <!-- Logo -->
          <div class="app-brand justify-content mb-4 mt-2">
          <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["height"=>90,"withbg"=>'fill: #fff;'])</span>
              <span class="app-brand-text demo text-body fw-bold ms-1">
                  {{config('variables.templateName')}}<br/>
                  <small>UNIVERSITAS MUHAMMADIYAH METRO</small>
              </span>
            </a>
          </div>
          <!-- /Logo -->

        <p class="mt-4">Login Menggunakan Akun SSO Dosen & Karyawan</p>
        
        @if ($errors->has('email'))
        <div class="alert alert-danger alert-dismissible d-flex align-items-baseline" role="alert">
          <span class="alert-icon alert-icon-lg text-danger me-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
          <div class="d-flex flex-column ps-1">
            <h5 class="alert-heading mb-2">Maaf!.</h5>
            <p class="mb-0">NIDN/NBM/Email dan Password tidak Terdaftar!.</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
          </div>
        </div>
        @endif
        
        <form id="formAuthentication" class="mb-3" action="{{url('auth/authenticate')}}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">NIDN/NBM/Email</label>
            <input type="text" class="form-control" id="usernama" name="username" placeholder="" autofocus>
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="password">Password</label>
              <a href="{{url('auth/forgot')}}">
                <small>Lupa Password ?</small>
              </a>
            </div>
            <div class="input-group input-group-merge">
              <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember-me">
              <label class="form-check-label" for="remember-me">
                Remember Me
              </label>
            </div>
          </div>
          <button class="btn btn-primary d-grid w-100">
            Sign in
          </button>
        </form>
        <a href="{{url('auth/google')}}" class="btn btn-google-plus btn-block w-100 mt-1">
          <i class="tf-icons ti ti-brand-google me-1"></i> Login Menggunakan Google+
        </a>
        <p class="text-center mt-2">
          <span>Belum Memiliki Akun Login?</span>
        </p>
        <div class="btn-group me-3 btn-block w-100">
          <button class="btn btn-warning  dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pendaftaran Akun SIMAIK
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="{{url('auth/register/sdm')}}">Pendaftaran Menggunakan Akun SIMPEG</a></li>
          </ul>
        </div>
        
      </div>
    </div>
    <!-- /Login -->
  </div>
</div>
@endsection
