<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkerController extends Controller
{
    // Muestra la vista
    public function index()
    {
        return view('frontend.workers');
    }
}
