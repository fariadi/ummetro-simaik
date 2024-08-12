@inject('pegawaiRepository', 'App\Repositories\Pegawai\PegawaiRepository')
@php
$customizerHidden = 'customizer-hide';
$getPegawaiByField = $pegawaiRepository->getByField(['data' => ['id' => $id]]);
$rowPegawai = $getPegawaiByField->data;
$configData = Helper::appClasses();
$registered = false;

@endphp

@extends('layouts/layoutMaster')

@section('title', 'Registrasi Akun')

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
<script src="{{asset('assets/js/pegawai/pages-create-akun.js')}}"></script>
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
                    <span class="bs-stepper-title">Pegawai</span>
                    <span class="bs-stepper-subtitle">Biodata Pegawai</span>
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
                    <span class="bs-stepper-title">Password</span>
                    <span class="bs-stepper-subtitle">Buat Password</span>
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
                      <input type="text" name="name" id="name" class="form-control" value="{{ $rowPegawai->nm_sdm }}" placeholder="" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="tgl_lahir">TANGGAL LAHIR </label>
                      <input type="text" name="tgl_lahir"  value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $rowPegawai->tgl_lahir)->format('d/m/Y') }}" class="form-control" placeholder="" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="tmpt_lahir">TEMPAT LAHIR</label>
                      <input type="text" name="tmpt_lahir" id="tmpt_lahir" value="{{ $rowPegawai->tmpt_lahir }}" class="form-control" placeholder="" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="jk">JENIS KELAMIN</label>
                      <select id="jk" name="jk" class="form-select" aria-label="Kelamin">
                        <option value="L" {{ ($rowPegawai->jk == 'L') ? 'selected' : ''}}>Laki-Laki</option>
                        <option value="P" {{ ($rowPegawai->jk == 'P') ? 'selected' : ''}}>Perempuan</option>
                      </select>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="email">ALAMAT EMAIL</label>
                      <input type="email" name="email" id="email" class="form-control" value="{{ $rowPegawai->email }}" placeholder="exsampel@email.com" aria-label="john.doe" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="telepon_seluler">NOMOR HP</label>
                      <input type="text" name="telepon_seluler" id="telepon_seluler" class="form-control" value="{{ $rowPegawai->no_hp }}" placeholder="0800 0000 0000" />
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
                      <input type="text" name="jln" id="jln" class="form-control" value="{{ $rowPegawai->jln }}" placeholder="Jl. Ki Hajar Dewantara" aria-label="Jl. Ki Hajar Dewantara" />
                    </div>
                    <input type="hidden" id="nbm" name="nbm" value="{{ $rowPegawai->nbm }}">
                    <input type="hidden" id="sdm" name="pegawai_id" value="{{ $rowPegawai->id }}">
                    <input type="hidden" id="mhs_prodi_kode" name="mhs_prodi_kode" value="">
                    <input type="hidden" id="mhs_prodi_nama" name="mhs_prodi_nama" value="">
                    <div class="col-12 d-flex justify-content-between mt-4">
                      <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                      </button>
                      <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Simpan & Lanjut</span> <i class="ti ti-arrow-right ti-xs"></i></button>
                    </div>
                  </div>
                </div>
                <!-- Buat Password -->
                <div id="personalInfoValidation" class="content form-block">
                  <div class="content-header mb-4">
                    <h3 class="mb-1">Buat Password</h3>
                    <p>Silahkan masukan password yang mudah anda ingat</p>
                  </div>
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <label class="form-label" for="username_sso">Username</label>
                      <input type="text" name="username_sso" id="username_sso" value="" class="form-control" placeholder="" />
                    </div>
                  <div>
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
                            <td class="ps-0 border-bottom" colspan="2">AKUN LOGIN SAUDARA</td>
                          </tr>
                          <tr class="bg-primary text-white">
                            <td class="col-lg-3 ps-2 align-top text-nowrap py-2">Email/Username</td>
                            <td class="col-lg-9 px-2 py-2"><span class="fw-semibold lbl-nama">{{ $registered->email }}</span></td>
                          </tr>
                          <tr class="bg-primary text-white border-top">
                            <td class="col-lg-3 ps-2 align-top text-nowrap py-2">Password</td>
                            <td class="col-lg-9 px-2 py-2"><span class="fw-semibold lbl-nama">*********</span></td>
                          </tr>
                          <tr>
                            <td class="ps-0 border-bottom border-top" colspan="2">DATA PEGAWAI</td>
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
        </div>
        <div class="col-12 d-flex justify-content-between">
            <a href="{{url('auth/login')}}" class="btn btn-primary" disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">Halaman Login</span>
            </a>
            <a href="{{url('auth/register/clear')}}" class="btn btn-warning"> <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Clear History</span> <i class="ti ti-arrow-right"></i></a>
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
