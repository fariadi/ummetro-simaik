@inject('biodataRepository', 'App\Repositories\Pegawai\BiodataRepository')
@php
$id = null;
$profil  = Auth::guard('peserta')->user();
$pegawai = $biodataRepository->firstWithUser($profil->id);
$customizerHidden = 'customizer-hide';

$configData = Helper::appClasses();
$registered = false;

@endphp

@extends('layouts/layoutMaster')

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
<script src="{{asset('assets/js/front/pages-ranting-update.js')}}"></script>
<script>
  var pegawaiId = "{{ $pegawai->id }}";
</script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Dashboard /</span> Ranting/Cabang/Daerah
</h4>
<div class="row">
  <div class="col-md-12">
    <!-- Create an API key -->
    <div class="card mb-4">
      <h5 class="card-header">Perubahan Ranting/Cabang/Daerah</h5>
      <div class="row">
        <div class="col-md-5 order-md-0 order-1">
          <div class="card-body" id="card-ranting">
            <form id="formRanting" method="POST" onsubmit="return false">
                <div class="row mb-3">
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="ranting_tingkat">Tingkat</label>
                    <select id="ranting_tingkat" name="ranting_tingkat" class="select2 form-select" aria-label="">
                        <option selected></option>
                        <option value="ranting">Ranting</option>
                        <option value="cabang">Cabang</option>
                        <option value="daerah">Daerah</option>
                    </select>
                  </div>
                </div>
                <div class="row  mb-3 col-daerah">
                    <div class="col-12 col-md-12">
                      <label class="form-label" for="ranting_prv_kode">Provinsi</label>
                      <select id="ranting_prv_kode" name="ranting_prv_kode" class="form-select select2_prov" aria-label="Pilih provinsi">
                        <option selected></option>
                      </select>
                    </div>
                </div>
                <div class="row  mb-3 col-cabang">
                    <div class="col-12 col-md-12">
                      <label class="form-label" for="ranting_kab_kode">Kab/Kota</label>
                      <select id="ranting_kab_kode" name="ranting_kab_kode" class="form-select select2_kab" aria-label="Pilih kabupaten">
                        <option selected></option>
                      </select>
                    </div>
                </div>
                <div class="row  mb-3 col-ranting">
                    <div class="col-12 col-md-12">
                      <label class="form-label" for="ranting_kec_kode">Kecamatan</label>
                      <select id="ranting_kec_kode" name="ranting_kec_kode" class="form-select select2_kec" aria-label="Pilih kecamatan">
                        <option selected></option>
                      </select>
                    </div>
                </div>
                <div class="row  mb-3">
                    <div class="col-12 col-md-12">
                      <label class="form-label" for="ranting_jalan">Alamat</label>
                      <input type="text" id="ranting_jalan" name="ranting_jalan" class="form-control" placeholder="Jl.." />
                    </div>
                </div>
                <div class="row  mb-3">
                    <div class="col-12 col-md-12">
                      <label class="form-label" for="ranting_desa_kel">Ranting/Desa/Kelurahan</label>
                      <input type="text" id="ranting_desa_kel" name="ranting_desa_kel" class="form-control" placeholder="" />
                    </div>
                </div>
                <div class="row">
                    <div class="mt-4">
                      <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                      <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
        <div class="col-md-7 order-md-1 order-0">
          <div class="text-center mt-4 mx-3 mx-md-0">
            <img src="{{asset('assets/img/illustrations/muslim-couple.jpg')}}" class="img-fluid" alt="Image" width="70%">
          </div>
        </div>
      </div>
    </div>
    <!--/ Create an API key -->
  </div>
</div>
@endsection
