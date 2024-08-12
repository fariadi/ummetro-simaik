@inject('biodataRepository', 'App\Repositories\Pegawai\BiodataRepository')
@php
$configData = Helper::appClasses();
$profil  = Auth::guard('peserta')->user();
$pegawai = $biodataRepository->firstWithUser($profil->id);
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
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
<script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
@endsection

@section('page-script')
<script>
    var pegawaiId = "{{ $pegawai->id }}";
</script>
<script src="{{asset('assets/js/extended-ui-perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/js/libs/form-data-json.min.js')}}"></script>
<script src="{{asset('assets/js/front/pages-home.js')}}"></script>
<script src="{{asset('assets/js/front/pages-bbq-tables.js')}}"></script>
<script src="{{asset('assets/js/front/modal-aktivitas-ranting-add.js')}}"></script>
<script src="{{asset('assets/js/users/modal-foto-add.js')}}"></script>

@endsection

@section('content')
<h3>
  Dashboard
  <small class="text-muted">Halaman Home</small>
</h3>
<!--
<div class="row">
    <div class="col-md-12 mb-4 mb-md-2">
      <div class="alert alert-warning bg-warning text-white alert-dismissible d-flex align-items-baseline" role="alert">
        <span class="alert-icon alert-icon-lg text-primary me-2">
          <i class="ti ti-user ti-sm"></i>
        </span>
        <div class="d-flex flex-column ps-1 text-white">
          <h5 class="alert-heading mb-2">Biodata!</h5>
          <p class="mb-0">Mohon lengkapi form biodata saudara .</p>
          
          <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"> </button>
        </div>
      </div>
    </div>
</div>
-->
<div class="row">
  <div class="col-md-6">
    <div class="card mb-4">
      <h5 class="card-header">Profile Details</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{ ($profil->foto) ? asset('storage/'.$profil->foto) : asset('assets/img/avatars/0.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
              <span class="d-none d-sm-block">Upload new photo</span>
              <i class="ti ti-upload d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
            </label>
            <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
              <i class="ti ti-refresh-dot d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>

            <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K </div>
          </div>
        </div>
        <p class="mt-4 small text-uppercase text-muted">Details</p>
        <div class="info-container">
          <dl class="row mt-2">
            <dt class="col-sm-3">Nama Lengkap</dt>
            <dd class="col-sm-9">{{ $pegawai->nama_lengkap }}</dd>

            <dt class="col-sm-3">Kelamin</dt>
            <dd class="col-sm-9">{{ ($profil->jk == 'L') ? 'Laki - Laki' : 'Perempuan' }}</dd>

            <dt class="col-sm-3">Alamat</dt>
            <dd class="col-sm-9">
              <p>{{ $profil->jln }}</p>
            </dd>
            <dt class="col-sm-3 text-truncate">No. HP</dt>
            <dd class="col-sm-9">
            {{ $profil->telepon_seluler }}
            </dd>

            <dt class="col-sm-3 text-truncate">Email</dt>
            <dd class="col-sm-9">
            {{ $profil->email  }}
            </dd>
          </dl>
        </div>
      </div>
      <!--
      <hr class="my-0">
      <div class="card-body">
        <div class="alert alert-danger alert-dismissible d-flex align-items-baseline" role="alert">
          <span class="alert-icon alert-icon-lg text-primary me-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
          <div class="ps-1">
            <h5 class="alert-heading mb-2">Data calon ujikom</h5>
            <p class="">Mohon lengkapi form data pokok saudara </p>
            
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
            <a href="{{url('home')}}" class="btn btn-danger">Lengkapi sekarang</a>
          </div>
        </div>
      </div>
      -->
      <!-- /Account -->
    </div>
  </div>

  <div class="col-md-6">
    <div class="card  mb-3">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-home" aria-controls="navs-tab-home" aria-selected="true">Informasi Ranting/Cabang/Daerah</button>
          </li>
          <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-profile" aria-controls="navs-tab-profile" aria-selected="false">Aktivitas Ranting/Cabang/Daerah</button>
          </li>
        </ul>
      </div>
      <div class="card-body mt-4">
        <div class="tab-content p-0">
          <div class="tab-pane fade show active" id="navs-tab-home" role="tabpanel">
            <h5 class="card-title">Detail</h5>

            <div class="info-container">
              <dl class="row mt-2">
                <dt class="col-sm-3">Nama Ranting</dt>
                <dd class="col-sm-9">
                  {{ ($pegawai->ranting_tingkat === 'ranting') ? strtoupper($pegawai->ranting_tingkat . ' '. $pegawai->rantingKec->nama) : '' }}
                  {{ ($pegawai->ranting_tingkat === 'cabang') ? strtoupper($pegawai->ranting_tingkat . ' '. $pegawai->rantingKab->nama) : '' }}
                </dd>
                <dt class="col-sm-3">Tingkat</dt>
                <dd class="col-sm-9">{{ ($pegawai->ranting_tingkat) ? strtoupper($pegawai->ranting_tingkat) : 'Tidak ada' }}</dd>

                <dt class="col-sm-3">Provinsi</dt>
                <dd class="col-sm-9">{{ ($pegawai->rantingProv) ? $pegawai->rantingProv->nama : '-' }}</dd>

                <dt class="col-sm-3">Kabupaten</dt>
                <dd class="col-sm-9">{{ ($pegawai->rantingKab) ? $pegawai->rantingKab->nama : '-' }}</dd>

                <dt class="col-sm-3">Kecamatan</dt>
                <dd class="col-sm-9">{{ ($pegawai->rantingKec) ? $pegawai->rantingKec->nama : '-' }}</dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">{{ ($pegawai->ranting_jalan) ? $pegawai->ranting_jalan : '-'}}</dd>

                <dt class="col-sm-3 text-truncate">Desa/Kelurahan</dt>
                <dd class="col-sm-9">{{ ($pegawai->ranting_desa_kel) ? $pegawai->ranting_desa_kel : '-' }}</dd>
                
              
              </dl>
              <hr/>
              <a href="{{url('front/ranting')}}" class="btn btn-warning">Perubahan ranting</a>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-tab-profile" role="tabpanel">
            <h5 class="card-title">Aktivitas</h5>
          
            <hr/>
            <a href="javascript:void(0);" class="btn btn-primary on-add-aktivitas-ranting" data-pegawai="{{ $pegawai->id }}" data-bs-toggle="modal" data-bs-target="#modal-aktvts-ranting-add">Tambah Aktivitas</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
<div class="col-md-12">
    <div class="card  mb-3">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-bbq" aria-controls="navs-tab-bbq" aria-selected="true">Pengajuan Baru</button>
          </li>
          <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-surah" aria-controls="navs-tab-surah" aria-selected="false">Riwayat Hafalan Surah & Ayat</button>
          </li>
        </ul>
      </div>
      <div class="card-body mt-4">
        <div class="tab-content p-0">
          <div class="tab-pane fade show active" id="navs-tab-bbq" role="tabpanel">
            <h5 class="card-title">Pengajuan Surah dan Ayat</h5>
            <div class="table-responsive text-nowrap">
              <table class="dt-table-bbq1 table">
                <thead class="border-top table-light">
                  <tr>
                    <th>NO</th>
                    <th>NAMA SURAT</th>
                    <th>AYAT YANG DI HAFAL</th>
                    <th>MENTOR</th>
                    <th>#</th>
                  </tr>
                </thead>
              </table>
            </div>
            <hr/>
            <a href="{{url('front/bbq/create')}}" class="btn btn-warning">Buat Pengajuan</a>
          </div>
          <div class="tab-pane fade" id="navs-tab-surah" role="tabpanel">
            <h5 class="card-title">Aktivitas</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="javascript:void(0);" class="btn btn-primary">Go profile</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('_partials/_modals/modal-aktivitas-ranting-add')
@endsection
