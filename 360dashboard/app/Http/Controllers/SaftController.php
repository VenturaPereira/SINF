<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;

class SaftController extends Controller
{
    public function index()
    {
        return view ('pages.saftmanager');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'saftFile' => 'required'
        ]);

    

        //save XML in db
        return redirect('/home')->with('success', 'SAFT Updated');
    }
}
