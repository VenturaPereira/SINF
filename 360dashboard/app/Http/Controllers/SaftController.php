<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Customer;
use App\Products;
use App\Suppliers;
use App\Invoices;
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

            if (array_key_exists('CustomerID', $customer))
                $newCustomer->CustomerID = strval($customer["CustomerID"]);
            if (array_key_exists('AccountID', $customer))
                $newCustomer->AccountID = intval($customer["AccountID"]);
            if (array_key_exists('CustomerTaxID', $customer))
                $newCustomer->CustomerTaxID = intval($customer["CustomerTaxID"]);
            if (array_key_exists('CompanyName', $customer))
                $newCustomer->CompanyName = strval($customer["CompanyName"]);
            if (array_key_exists('AddressDetail', $customer["BillingAddress"]))
                $newCustomer->BillingAddress_AddressDetail = strval($customer["BillingAddress"]["AddressDetail"]);
            if (array_key_exists('City', $customer["BillingAddress"]))
                $newCustomer->BillingAddress_City = strval($customer["BillingAddress"]["City"]);
            if (array_key_exists('PostalCode', $customer["BillingAddress"]))
                $newCustomer->BillingAddress_PostalCode = strval($customer["BillingAddress"]["PostalCode"]);
            if (array_key_exists('Country', $customer["BillingAddress"]))
                $newCustomer->BillingAddress_Country = strval($customer["BillingAddress"]["Country"]);
            if (array_key_exists('AddressDetail', $customer["ShipToAddress"]))
                $newCustomer->ShipToAddress_AddressDetail = strval($customer["ShipToAddress"]["AddressDetail"]);
            if (array_key_exists('City', $customer["ShipToAddress"]))
                $newCustomer->ShipToAddress_City = strval($customer["ShipToAddress"]["City"]);
            if (array_key_exists('PostalCode', $customer["ShipToAddress"]))
                $newCustomer->ShipToAddress_PostalCode = strval($customer["ShipToAddress"]["PostalCode"]);
            if (array_key_exists('Country', $customer["ShipToAddress"]))
                $newCustomer->ShipToAddress_Country = strval($customer["ShipToAddress"]["Country"]);

            $newCustomer->save();
         

        }
        
        //loop products and save
        foreach ($array["MasterFiles"]["Product"] as $product){

            $newProduct = new Products;

            if (array_key_exists('ProductType', $product))
                $newProduct->ProductType = strval($product["ProductType"]);
            if (array_key_exists('ProductCode', $product))
                $newProduct->ProductCode = strval($product["ProductCode"]);
            if (array_key_exists('ProductGroup', $product))
                $newProduct->ProductGroup = strval($product["ProductGroup"]);
            if (array_key_exists('ProductDescription', $product))
                $newProduct->ProductDescription = strval($product["ProductDescription"]);
            if (array_key_exists('ProductNumberCode', $product))
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
            if (array_key_exists('AddressDetail', $supplier["BillingAddress"]))
                $newsupplier->BillingAddress_AddressDetail = strval($supplier["BillingAddress"]["AddressDetail"]);
            if (array_key_exists('City', $supplier["BillingAddress"]))
                $newsupplier->BillingAddress_City = strval($supplier["BillingAddress"]["City"]);
            if (array_key_exists('PostalCode', $supplier["BillingAddress"]))
                $newsupplier->BillingAddress_PostalCode = strval($supplier["BillingAddress"]["PostalCode"]);
            if (array_key_exists('Country', $supplier["BillingAddress"]))
                $newsupplier->BillingAddress_Country = strval($supplier["BillingAddress"]["Country"]);
            if (array_key_exists('AddressDetail', $supplier["ShipFromAddress"]))
                $newsupplier->ShipFromAddress_AddressDetail = strval($supplier["ShipFromAddress"]["AddressDetail"]);
            if (array_key_exists('City', $supplier["ShipFromAddress"]))
                $newsupplier->ShipFromAddress_City = strval($supplier["ShipFromAddress"]["City"]);
            if (array_key_exists('PostalCode', $supplier["ShipFromAddress"]))
                $newsupplier->ShipFromAddress_PostalCode = strval($supplier["ShipFromAddress"]["PostalCode"]);
            if (array_key_exists('Country', $supplier["ShipFromAddress"]))
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

        //loop Invoices and save
        foreach ($array["SourceDocuments"]["SalesInvoices"]["Invoice"] as $invoice){

            $newinvoice = new Invoices;

            if (array_key_exists('InvoiceNo', $invoice))
                $newinvoice->InvoiceNo = strval($invoice["InvoiceNo"]);
            if (array_key_exists('ATCUD', $invoice))
                $newinvoice->ATCUD = strval($invoice["ATCUD"]);

            $newinvoice->save();
        }
    

        //save XML in db
        return redirect('/home')->with('success', 'Database is now updated according to SAFT');
    }
}
