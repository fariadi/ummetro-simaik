@php
$configData = Helper::appClasses();
@endphp
@inject('usersRepository', 'App\Repositories\Users\UsersRepository')
@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/pages-dashboard.js')}}"></script>
@endsection

@section('content')
<div class="row">
  <!-- View sales -->
  <div class="col-xl-4 mb-4 col-lg-5 col-12">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-7">
          <div class="card-body text-nowrap">
            @if (Auth::check())
              <h5 class="card-title mb-0">Selamat datang {{ Auth::user()->name }}! 🎉</h5>
              <p class="mb-2">Administrator AIK</p>
            @else
             <h5 class="card-title mb-0">Selamat datang ! 🎉</h5>
             <p class="mb-2">Administrator</p>
            @endif
            
            <!--
            <h4 class="text-primary mb-1">$48.9k</h4>
            <a href="javascript:;" class="btn btn-primary">View Sales</a>
            !-->
          </div>
        </div>
        <div class="col-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{asset('assets/img/illustrations/card-advance-sale.png')}}" height="140" alt="view sales">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- View sales -->

  <!-- Statistics -->
  <div class="col-xl-8 mb-4 col-lg-7 col-12">
    <div class="card h-100">
      <div class="card-header">
        <div class="d-flex justify-content-between mb-3">
          <h5 class="card-title mb-0">Statistics</h5>
          <small class="text-muted"></small>
        </div>
      </div>
      
    </div>
  </div>
  <!--/ Statistics -->

  <div class="col-xl-4 col-12">
        <div class="card">
          <div class="card-header pb-0">
            <h5 class="card-title mb-0">0.0</h5>
            <small class="text-muted">Exsample</small>
          </div>
          <div class="card-body">
            <div id="expensesChart"></div>
            <div class="mt-md-2 text-center mt-lg-3 mt-3">
              <small class="text-muted mt-3">Exsampel data</small>
            </div>
          </div>
        </div>
  </div>
@endsection
