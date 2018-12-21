<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoices;

session_start();

if (isset($_SESSION['saftUploaded']) && Invoices::count() > 0 )
{
    //Do nothing
}
else{
    $_SESSION["saftUploaded"] = "false";
}


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
