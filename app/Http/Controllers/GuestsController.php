<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Guest;

class GuestsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function all()
    {
      return Guest::get();
    }
}
