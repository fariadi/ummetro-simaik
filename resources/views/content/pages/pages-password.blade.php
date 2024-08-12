@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster', [
  'pageConfigs' => ['menuName' => 'peserta']
])

@section('title', 'Home')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-account-settings.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/pages-password.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Account Settings /</span> Security
</h4>
<div class="row">
  <div class="col-md-12">
    <!-- Create an API key -->
    <div class="card mb-4">
      <h5 class="card-header">Ubah Password</h5>
      <div class="row">
        <div class="col-md-5 order-md-0 order-1">
          <div class="card-body">
            <form id="formAccountSettings" method="POST" onsubmit="return false">
                <div class="row">
                    <div class="mb-3 col-md-8 form-password-toggle">
                    <label class="form-label" for="new_password">New Password</label>
                    <div class="input-group input-group-merge">
                        <input class="form-control" type="password" id="new_password" name="new_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-8 form-password-toggle">
                        <label class="form-label" for="confirm_new_password">Confirm New Password</label>
                        <div class="input-group input-group-merge">
                            <input class="form-control" type="password" name="confirm_new_password" id="confirm_new_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                    <h6>Password Requirements:</h6>
                    <ul class="ps-3 mb-0">
                        <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                        <li class="mb-1">At least one lowercase character</li>
                        <li>At least one number, symbol, or whitespace character</li>
                    </ul>
                    </div>
                    <div>
                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
        <div class="col-md-7 order-md-1 order-0">
          <div class="text-center mt-4 mx-3 mx-md-0">
            <img src="{{asset('assets/img/illustrations/girl-with-laptop.png')}}" class="img-fluid" alt="Api Key Image" width="202">
          </div>
        </div>
      </div>
    </div>
    <!--/ Create an API key -->
  </div>
</div>
@endsection