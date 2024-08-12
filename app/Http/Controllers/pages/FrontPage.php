<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontPage extends Controller
{

  public function index()
  {
    return view('content.pages.pages-home');
  }

  public function bbqFormAdd()
  {
    return view('content.front.pages-bbq-create');
  }

  public function rantingEdit()
  {
    return view('content.front.pages-ranting-update');
  }

  public function password()
  {
    return view('content.front.pages-password');
  }

}
