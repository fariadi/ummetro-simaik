<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Helper;


class HomePage extends Controller
{

  public function index()
  {
    $menu = Helper::userMenu();
    if($menu === 'mentor') {
      return view('content.mentor.pages-index');
    }
    return view('content.pages.pages-dashboard');
  }
}