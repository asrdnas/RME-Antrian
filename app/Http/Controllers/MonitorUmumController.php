<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitorUmumController extends Controller
{
    public function index()
    {
         return view('monitor.antrianumum');
    }
}
