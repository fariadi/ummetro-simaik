<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;




class AdminPage extends Controller
{

  public function index()
  {
    return view('content.pages.pages-dashboard');
  }

  public function refWilayah()
  {
    return view('content.pages.ref-wilayah');
  }

  public function refAlquran()
  {
    return view('content.pages.ref-alquran');
  }

  public function users()
  {
    return view('content.pages.pages-users');
  }

  public function pegawai()
  {
    return view('content.pages.pages-pegawai');
  }

  public function pegawaiCreate(
    $id = null
  )
  {
    return view('content.pages.pages-pegawai-id-create', [
      'id' => $id
    ]);
  }

  public function pegawaiDetail(
    $id = null
  )
  {
    return view('content.pages.pages-pegawai-id', [
      'id' => $id
    ]);
  }

}
