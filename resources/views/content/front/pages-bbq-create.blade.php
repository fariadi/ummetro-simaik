@inject('biodataRepository', 'App\Repositories\Pegawai\BiodataRepository')
@php
$id = null;
$profil  = Auth::guard('peserta')->user();
$pegawai = $biodataRepository->firstWithUser($profil->id);
$customizerHidden = 'customizer-hide';

$configData = Helper::appClasses();
$registered = false;

@endphp

@extends('layouts/layoutMaster', [
  'pageConfigs' => ['menuName' => 'peserta']
])

@section('title', 'Ranting')

@section('vendor-style')
<!-- Vendor -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/js/moment.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/front/pages-bbq-create.js?ver=1.1.0')}}"></script>
<script>
  var pegawaiId = "{{ $pegawai->id }}";
</script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Dashboard /</span> Pegajuan Surah dan Ayat
</h4>
<div class="row">
  <div class="col-md-12">
    <!-- Create an API key -->
    <div class="card mb-4">
      <h5 class="card-header">Ajukan Surah & Ayat</h5>
      <div class="row">
        <div class="col-md-5 order-md-0 order-1">
          <div class="card-body" id="card-ranting">
            <form id="formBbq" method="POST" onsubmit="return false">
                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                <div class="row  mb-3 col-daerah">
                    <div class="col-12 col-md-12">
                      <label class="form-label" for="surat_id">Nama surah</label>
                      <select id="surat_id" name="surat_id" class="form-select select2_surat" aria-label="Pilih nama surah">
                        <option selected></option>
                      </select>
                    </div>
                </div>
                <div class="row mb-3">
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="mulai_ayat_ke">Mulai Ayat Ke</label>
                    <input type="text" id="mulai_ayat_ke" name="mulai_ayat_ke" class="form-control" placeholder="0" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="sampai_ayat_ke">Sampai dengan Ayat</label>
                    <input type="text" id="sampai_ayat_ke" name="sampai_ayat_ke" class="form-control" placeholder="0" />
                  </div>
                </div>
                <div class="row">
                    <div class="mt-4">
                      <button type="submit" class="btn btn-primary me-2">Simpan & Ajukan</button>
                      <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
        <div class="col-md-7 order-md-1 order-0">
          <div class="text-center mt-4 mx-3 mx-md-0">
            <!--
            <img src="{{asset('assets/img/illustrations/girl-with-laptop.png')}}" class="img-fluid" alt="Api Key Image" width="202">
            !-->
          </div>
        </div>
      </div>
    </div>
    <!--/ Create an API key -->
  </div>
</div>
@endsection
