<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Customer;
use App\Products;
use App\Suppliers;
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
        
        //read from SAFT.xml on /public folder
        $file = $request->file('file');
        $filename=$file->getClientOriginalName();
        $file_path=$file->getRealPath();
        $file_content = File::get($file_path.'\SAFT.xml');

        $xml = simplexml_load_string($file_content);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        //before update this will delete all rows
        DB::table('customers')->delete();
        DB::table('products')->delete();
        DB::table('suppliers')->delete();

        //loop customers and save
        foreach ($array["MasterFiles"]["Customer"] as $customer){

            $newCustomer = new Customer;
            $newCustomer->CustomerID = strval($customer["CustomerID"]);
            $newCustomer->AccountID = intval($customer["AccountID"]);
            $newCustomer->CustomerTaxID = intval($customer["CustomerTaxID"]);
            $newCustomer->CompanyName = strval($customer["CompanyName"]);
            $newCustomer->BillingAddress_AddressDetail = strval($customer["BillingAddress"]["AddressDetail"]);
            $newCustomer->BillingAddress_City = strval($customer["BillingAddress"]["City"]);
            $newCustomer->BillingAddress_PostalCode = strval($customer["BillingAddress"]["PostalCode"]);
            $newCustomer->BillingAddress_Country = strval($customer["BillingAddress"]["Country"]);
            $newCustomer->ShipToAddress_AddressDetail = strval($customer["ShipToAddress"]["AddressDetail"]);
            $newCustomer->ShipToAddress_City = strval($customer["ShipToAddress"]["City"]);
            $newCustomer->ShipToAddress_PostalCode = strval($customer["ShipToAddress"]["PostalCode"]);
            $newCustomer->ShipToAddress_Country = strval($customer["ShipToAddress"]["Country"]);

            $newCustomer->save();
         

        }
        
        //loop products and save
        foreach ($array["MasterFiles"]["Product"] as $product){

            $newProduct = new Products;
            $newProduct->ProductType = strval($product["ProductType"]);
            $newProduct->ProductCode = strval($product["ProductCode"]);
            $newProduct->ProductGroup = strval($product["ProductGroup"]);
            $newProduct->ProductDescription = strval($product["ProductDescription"]);
            $newProduct->ProductNumberCode = strval($product["ProductNumberCode"]);

            $newProduct->save();
         

        }

        //loop suppliers and save
        foreach ($array["MasterFiles"]["Supplier"] as $supplier){

          
            $newsupplier = new Suppliers;
            
            if (array_key_exists('SupplierID', $supplier))
                $newsupplier->SupplierID = strval($supplier["SupplierID"]);
            if (array_key_exists('AccountID', $supplier))
                $newsupplier->AccountID = intval($supplier["AccountID"]);
            if (array_key_exists('SupplierTaxID', $supplier))
                $newsupplier->SupplierTaxID = intval($supplier["SupplierTaxID"]);
            if (array_key_exists('CompanyName', $supplier))
                $newsupplier->CompanyName = strval($supplier["CompanyName"]);
            if (array_key_exists('BillingAddress', $supplier))
                $newsupplier->BillingAddress_AddressDetail = strval($supplier["BillingAddress"]["AddressDetail"]);
            if (array_key_exists('BillingAddress', $supplier))
                $newsupplier->BillingAddress_City = strval($supplier["BillingAddress"]["City"]);
            if (array_key_exists('BillingAddress', $supplier))
                $newsupplier->BillingAddress_PostalCode = strval($supplier["BillingAddress"]["PostalCode"]);
            if (array_key_exists('BillingAddress', $supplier))
                $newsupplier->BillingAddress_Country = strval($supplier["BillingAddress"]["Country"]);
            if (array_key_exists('ShipFromAddress', $supplier))
                $newsupplier->ShipFromAddress_AddressDetail = strval($supplier["ShipFromAddress"]["AddressDetail"]);
            if (array_key_exists('ShipFromAddress', $supplier))
                $newsupplier->ShipFromAddress_City = strval($supplier["ShipFromAddress"]["City"]);
            if (array_key_exists('ShipFromAddress', $supplier))
                $newsupplier->ShipFromAddress_PostalCode = strval($supplier["ShipFromAddress"]["PostalCode"]);
            if (array_key_exists('ShipFromAddress', $supplier))
                $newsupplier->ShipFromAddress_Country = strval($supplier["ShipFromAddress"]["Country"]);
            if (array_key_exists('Telephone', $supplier))
                $newsupplier->Telephone = intval($supplier["Telephone"]);
            if (array_key_exists('Fax', $supplier))
                $newsupplier->Fax = intval($supplier["Fax"]);
            if (array_key_exists('Website', $supplier))
                $newsupplier->Website = strval($supplier["Website"]);
            if (array_key_exists('SelfBillingIndicator', $supplier))
                $newsupplier->SelfBillingIndicator = strval($supplier["SelfBillingIndicator"]);

            $newsupplier->save();

        }
    

        //save XML in db
        return redirect('/home')->with('success', 'SAFT Updated');
    }
}
