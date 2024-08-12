@php
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Registrasi Akun - Penmaru UM Metro')

@section('vendor-style')
<!-- Vendor -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />

@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/block-ui/block-ui.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/authentication/pages-register.js')}}"></script>
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover authentication-bg">
  <div class="authentication-inner row">

    <!-- Left Text -->
    <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-center p-5 auth-cover-bg-color position-relative auth-multisteps-bg-height">
      <img src="{{ asset('assets/img/illustrations/auth-reset-password-illustration-'.$configData['style'].'.png') }}" alt="auth-register-multisteps" class="img-fluid" width="280">

      <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}" alt="auth-register-multisteps" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
    </div>
    <!-- /Left Text -->

    <!--  Multi Steps Registration -->
    
    <div class="d-flex col-lg-8 align-items-center justify-content-center pt-2">
      <div class="w-px-800">
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
        <hr>
        @if(!$registered)
          <div id="multiStepsValidation" class="bs-stepper shadow-none">
            <div class="bs-stepper-header border-bottom-0">
              <div class="step" data-target="#accountDetailsValidation">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle"><i class="ti ti-smart-home ti-sm"></i></span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Biodata</span>
                    <span class="bs-stepper-subtitle">Form Biodata</span>
                  </span>
                </button>
              </div>
              <div class="line">
                <i class="ti ti-chevron-right"></i>
              </div>
              <div class="step" data-target="#personalInfoValidation">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle"><i class="ti ti-users ti-sm"></i></span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Buat Password</span>
                    <span class="bs-stepper-subtitle">Konfirmasi Password</span>
                  </span>
                </button>
              </div>
              <div class="line">
                <i class="ti ti-chevron-right"></i>
              </div>
              <div class="step" data-target="#billingLinksValidation">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle"><i class="ti ti-file-text ti-sm"></i></span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Pratinjau</span>
                    <span class="bs-stepper-subtitle">Konfirmasi Pendaftaran</span>
                  </span>
                </button>
              </div>
            </div>
            <div class="bs-stepper-content">
              <form id="formRegister" onSubmit="return false">
                <!-- Account Details -->
                <div id="accountDetailsValidation" class="content">
                  <div class="content-header mb-4">
                    <h3 class="mb-1">Biodata Pendaftaran</h3>
                    <p>Mohon masukan & lengkapi biodata dengan benar!.</p>
                  </div>
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <label class="form-label" for="name">NAMA LENGKAP</label>
                      <input type="text" name="name" id="name" class="form-control" placeholder="" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="tgl_lahir">TANGGAL LAHIR</label>
                      <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control" placeholder="dd/mm/yyyy" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="tmpt_lahir">TEMPAT LAHIR</label>
                      <input type="text" name="tmpt_lahir" id="tmpt_lahir" class="form-control" placeholder="" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="jk">JENIS KELAMIN</label>
                      <select id="jk" name="jk" class="select2 form-select" aria-label="Kelamin">
                        <option selected></option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="email">ALAMAT EMAIL</label>
                      <input type="email" name="email" id="email" class="form-control" placeholder="exsampel@email.com" aria-label="john.doe" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="telepon_seluler">NOMOR HP</label>
                      <input type="text" name="telepon_seluler" id="telepon_seluler" class="form-control" placeholder="0800 0000 0000" />
                    </div>
                    <!--
                    <div class="col-sm-6 form-password-toggle">
                      <label class="form-label" for="multiStepsPass">Password</label>
                      <div class="input-group input-group-merge">
                        <input type="password" id="multiStepsPass" name="multiStepsPass" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsPass2" />
                        <span class="input-group-text cursor-pointer" id="multiStepsPass2"><i class="ti ti-eye-off"></i></span>
                      </div>
                    </div>
                    <div class="col-sm-6 form-password-toggle">
                      <label class="form-label" for="multiStepsConfirmPass">Confirm Password</label>
                      <div class="input-group input-group-merge">
                        <input type="password" id="multiStepsConfirmPass" name="multiStepsConfirmPass" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsConfirmPass2" />
                        <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"><i class="ti ti-eye-off"></i></span>
                      </div>
                    </div>
                    -->
                    <div class="col-md-12">
                      <label class="form-label" for="jln">ALAMAT TEMPAT TINGGAL</label>
                      <input type="text" name="jln" id="jln" class="form-control" placeholder="Jl. Ki Hajar Dewantara" aria-label="Jl. Ki Hajar Dewantara" />
                    </div>
                    <div class="col-12 d-flex justify-content-between mt-4">
                      <a href="{{url('/')}}" class="btn btn-warning" disabled> <i class="ti ti-arrow-left ti-xs me-sm-1 me-0 text-white"></i>
                        <span class="align-middle d-sm-inline-block d-none text-white">Halaman Login</span>
                      </a>
                      <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Simpan & Lanjut</span> <i class="ti ti-arrow-right ti-xs"></i></button>
                    </div>
                  </div>
                </div>
                <!-- Buat Password Info -->
                <div id="personalInfoValidation" class="content form-block">
                  <div class="content-header mb-4">
                    <h3 class="mb-1">Buat Password</h3>
                    <p>Silahkan masukan password yang mudah anda ingat</p>
                  </div>
                  <div class="row g-3">
                    <div class="col-sm-6 form-password-toggle mb-3">
                      <label class="form-label" for="password">Password</label>
                      <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                      </div>
                    </div>
                    <div class="col-sm-6 form-password-toggle mb-3">
                      <label class="form-label" for="password_confirmation">Confirm Password</label>
                      <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                      </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between mt-4">
                      <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                      </button>
                      <button class="btn btn-primary btn-next btn-form-block-overlay"> <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span> <i class="ti ti-arrow-right ti-xs"></i></button>
                    </div>
                  </div>
                </div>
                <!-- Billing Links -->
                <div id="billingLinksValidation" class="content">
                  <div class="content-header">
                    <h3 class="mb-1">Pratinjau Pendaftar</h3>
                    <p>Pastikan data yang di tampilkan sudah benar!.</p>
                  </div>
                  <!-- Credit Card Details -->
                  <div class="row g-3">
                    <div class="col-12 mb-0">
                      <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td class="ps-0 border-bottom border-top" colspan="2">BIODATA PENDAFTARAN</td>
                          </tr>
                          <tr>
                            <td class="col-lg-3 ps-0 align-top text-nowrap py-1">Nama Lengkap</td>
                            <td class="col-lg-9 px-0 py-1"><span class="fw-semibold lbl-nama">...</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Tempat Lahir</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-tmpt_lahir">...</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Tanggal Lahir</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-tgl_lahir">...</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Jenis Kelamin</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-jk">...</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Alamat Email</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-email">...</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Nomor HP</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-telepon_seluler">...</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Alamat Tinggal</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-jln">...</span></td>
                          </tr>
                        </tbody>
                      </table>

                    </div>
                    <div class="col-md-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="formValidation" id="formValidation">
                        <label class="form-check-label" for="formValidation">Saya menyetujui bahwa data yang telah dimasukkan adalah Benar dan dapat dipertanggungjawabkan..</label>
                      </div>
                    </div>
                    
                    <div class="col-12 d-flex justify-content-between mt-4">
                      <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                      </button>
                      <button type="submit" class="btn btn-success btn-next btn-submit">Submit</button>
                    </div>
                  </div>
                  <!--/ Credit Card Details -->
                </div>
              </form>
            </div>
          </div>
        @endif

        @if($registered)
        <!-- Credit Card Details -->
        <div class="row g-3">
          <div class="col-12 mb-0">
                      <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td class="ps-0 border-bottom" colspan="2">BIODATA PENDAFTARAN</td>
                          </tr>
                          <tr>
                            <td class="col-lg-3 ps-0 align-top text-nowrap py-1">Nama Lengkap</td>
                            <td class="col-lg-9 px-0 py-1"><span class="fw-semibold lbl-nama">{{ $registered->name }}</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Tempat Lahir</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-tmpt_lahir">{{ $registered->tmpt_lahir }}</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Tanggal Lahir</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-tgl_lahir">{{ $registered->tgl_lahir }}</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Jenis Kelamin</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-jk">{{ ($registered->jk == 'L') ? 'Laki-Laki' : 'Perempuan' }}</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Alamat Email</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-email">{{ $registered->email }}</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Nomor HP</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-telepon_seluler">{{ $registered->telepon_seluler }}</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 align-top text-nowrap py-1">Alamat Tinggal</td>
                            <td class="px-0 py-1"><span class="fw-semibold lbl-jln">{{ $registered->jln }}</span></td>
                          </tr>
                        </tbody>
                      </table>
          </div>
          <div class="col-12 d-flex justify-content-between">
            <a href="{{url('auth/login')}}" class="btn btn-primary" disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">Halaman Login</span>
            </a>
            <a href="{{url('auth/register/clear')}}" class="btn btn-warning"> <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Clear History</span> <i class="ti ti-arrow-right"></i></a>
          </div>
        </div>
        @endif
                  <!--/ Credit Card Details -->

      </div>
    </div>
    <!-- / Multi Steps Registration -->
  </div>
</div>

<script>
  // Check selected custom option
  window.Helpers.initCustomOptionCheck();
</script>
@endsection
