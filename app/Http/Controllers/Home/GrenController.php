<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GrenController extends Controller
{
   public function gren()
   {
   		return view('home.gren.gren');
   }
}
