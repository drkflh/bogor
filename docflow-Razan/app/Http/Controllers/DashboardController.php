<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\AdminController;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
