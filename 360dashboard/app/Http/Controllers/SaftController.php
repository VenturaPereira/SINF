<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Customer;
use DB;
use File;

class SaftController extends Controller
{
    public function index()
    {
        return view ('pages.saftmanager');
    }

    public function store(Request $request)
    {
  
        $file = $request->file('file');
        $filename=$file->getClientOriginalName();
        $file_path=$file->getRealPath();
        $file_content = File::get($file_path.'\SAFT.xml');

        $xml = simplexml_load_string($file_content);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        //loop customers and save
        foreach ($array["MasterFiles"]["Customer"] as $customer){
            $newCustomer = new Customer;
            $newCustomer->CustomerID = strval($customer["CustomerID"]);
            $newCustomer->AccountID = intval($customer["AccountID"]);
            $newCustomer->CustomerTaxID = intval($customer["CustomerTaxID"]);
            $newCustomer->CompanyName = strval($customer["CompanyName"]);
            $newCustomer->save();
        }
            
            
        
    

        //save XML in db
        //return redirect('/home')->with('success', 'SAFT Updated');
    }
}
