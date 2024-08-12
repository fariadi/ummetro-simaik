<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MentorPage extends Controller
{

  public function index()
  {
    return view('content.mentor.pages-index');
  }

}