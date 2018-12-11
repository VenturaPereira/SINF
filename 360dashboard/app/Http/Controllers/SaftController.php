<?php

namespace App\Http\Controllers;


use App\Post;
use App\Customer;
use App\Products;
use App\Suppliers;
use App\Invoices;
use App\Lines;
use DB;
use File;
use Illuminate\Http\Request;
ini_set('max_execution_time', 300);

class SaftController extends Controller
{
    function readSaft($request){
        $file = $request->file('file');
        $filename=$file->getClientOriginalName();
        $file_path=$file->getRealPath();
        //windows1
            $file_content = File::get($file_path.'\SAFT.xml');
        //windows2
            //$file_content = File::get('C:\xampp\htdocs\SINF\360dashboard\public\SAFT.xml');
        //unix
            //$file_contents = File::get('/opt/lampp/htdocs/SINF/360dashboard/public/SAFT.xml'); 
        $xml = simplexml_load_string($file_content);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        return $array;
    }

    function apiRequestToken(){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_PORT => "4001",
          CURLOPT_URL => "http://localhost:4001/WebApi/token",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "username=FEUP&password=qualquer1&company=DEMOSINF&instance=DEFAULT&grant_type=password&line=line",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "Postman-Token: 948d5039-3e3b-4094-9638-99a7ca64e508",
            "cache-control: no-cache"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          $jsondata = json_decode($response, TRUE);
          return $jsondata["access_token"];
        }
    }

    function apiRequest($accessToken, $url, $query){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_PORT => "4001",
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "\"$query\"\r\n",
          CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$accessToken,
            "Content-Type: application/json",
            "Postman-Token: 6d32ab81-a824-40c7-9fb2-1e1c5b2a16fa",
            "cache-control: no-cache"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            $jsondata = json_decode($response, TRUE);
            return $jsondata;
        }
    }

    public function index()
    {
        return view ('pages.saftmanager');
    }

    public function store(Request $request)
    {

    
        //read from SAFT.xml on /public folder
        $array = self::readSaft($request);

        //Api call - Gives access token for future api calls
        //IMPORTANT: Need to turn on VM with Primavera and enable Port Forwarding at port 4001
        $accessToken = self::apiRequestToken();

        //Api Call - Gives all clients
        $url = "http://localhost:4001/WebApi/Administrador/Consulta";
        $query = "SELECT Cliente, Nome, Fac_Mor FROM Clientes";
        $apiClients = self::apiRequest($accessToken, $url, $query);
        
        //Api Call - Gives all Suppliers
        $url = "http://localhost:4001/WebApi/Administrador/Consulta";
        $query = "SELECT Fornecedor, Nome, Morada,Local,Cp,CpLoc,Tel,Fax,PrazoEnt,TotalDeb,LimiteCred,NumContrib,Pais FROM Fornecedores";
        $apiSuppliers = self::apiRequest($accessToken, $url, $query);

        //Api Call - Gives all CabecCompras
        $url = "http://localhost:4001/WebApi/Administrador/Consulta";
        $query = "SELECT Entidade, DataDoc, NumDocExterno, TotalMerc, TotalIva, TotalDesc, NumContribuinte, Nome FROM CabecCompras";
        $apiCabecCompras = self::apiRequest($accessToken, $url, $query);

        //loop CabeCompras and save
        //return $apiCabecCompras;
        foreach($apiCabecCompras["DataSet"]["Table"] as $cabeccompra)
        {
            //
        }

        //loop suppliers and save
        foreach($apiSuppliers["DataSet"]["Table"] as $supplier)
        {
            $newsupplier = new Suppliers;

            if (array_key_exists('Fornecedor', $supplier))
                $newsupplier->SupplierID = strval($supplier["Fornecedor"]);
            if (array_key_exists('NumContrib', $supplier))
                $newsupplier->SupplierTaxID = strval($supplier["NumContrib"]);
            if (array_key_exists('Nome', $supplier))
                $newsupplier->CompanyName = strval($supplier["Nome"]);
            if (array_key_exists('Morada', $supplier))
                $newsupplier->BillingAddress_AddressDetail = strval($supplier["Morada"]);
            if (array_key_exists('City', $supplier))
                $newsupplier->BillingAddress_City = strval($supplier["City"]);
            if (array_key_exists('Cp', $supplier))
                $newsupplier->BillingAddress_PostalCode = strval($supplier["Cp"]);
            if (array_key_exists('Pais', $supplier))
                $newsupplier->BillingAddress_Country = strval($supplier["Pais"]);
            if (array_key_exists('Tel', $supplier))
                $newsupplier->Telephone = strval($supplier["Tel"]);
            if (array_key_exists('Fax', $supplier))
                $newsupplier->Fax = strval($supplier["Fax"]);
            if (array_key_exists('TotalDeb', $supplier))
                $newsupplier->TotalDeb = strval($supplier["TotalDeb"]);
            if (array_key_exists('LimiteCred', $supplier))
                $newsupplier->LimiteCred = strval($supplier["LimiteCred"]);


            $newsupplier->save();

            
        }
        


        //loop customers and save
        foreach ($array["MasterFiles"]["Customer"] as $customer){

            $newCustomer = new Customer;

            if (array_key_exists('CustomerID', $customer))
                $newCustomer->CustomerID = strval($customer["CustomerID"]);
            if (array_key_exists('AccountID', $customer))
                $newCustomer->AccountID = strval($customer["AccountID"]);
            if (array_key_exists('CustomerTaxID', $customer))
                $newCustomer->CustomerTaxID = strval($customer["CustomerTaxID"]);
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
            //if (array_key_exists('ProductQuantity', $product))
                $newProduct->ProductQuantity = strval(rand(10,100));
                $newProduct->ProductSales = strval(rand(4,50));
                $newProduct->ProductUnitaryPrice = strval(rand(2,10));

            $newProduct->save();


        }

        //loop suppliers and save
     /*   foreach ($array["MasterFiles"]["Supplier"] as $supplier){


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

        }*/

        //loop Invoices and save
        foreach ($array["SourceDocuments"]["SalesInvoices"]["Invoice"] as $invoice){

            $newinvoice = new Invoices;

            if (array_key_exists('InvoiceNo', $invoice))
                $newinvoice->InvoiceNo = strval($invoice["InvoiceNo"]);
            if (array_key_exists('ATCUD', $invoice))
                $newinvoice->ATCUD = strval($invoice["ATCUD"]);

            if (array_key_exists('InvoiceStatus', $invoice["DocumentStatus"]))
                $newinvoice->DocumentStatus_InvoiceStatus = strval($invoice["DocumentStatus"]["InvoiceStatus"]);
            if (array_key_exists('InvoiceStatusDate', $invoice["DocumentStatus"]))
                $newinvoice->DocumentStatus_InvoiceStatusDate = strval($invoice["DocumentStatus"]["InvoiceStatusDate"]);
            if (array_key_exists('SourceID', $invoice["DocumentStatus"]))
                $newinvoice->DocumentStatus_SourceID = strval($invoice["DocumentStatus"]["SourceID"]);
            if (array_key_exists('SourceBilling', $invoice["DocumentStatus"]))
                $newinvoice->DocumentStatus_SourceBilling = strval($invoice["DocumentStatus"]["SourceBilling"]);

            if (array_key_exists('Hash', $invoice))
                $newinvoice->Hash = strval($invoice["Hash"]);
            if (array_key_exists('HashControl', $invoice))
                $newinvoice->HashControl = strval($invoice["HashControl"]);
            if (array_key_exists('Period', $invoice))
                $newinvoice->Period = strval($invoice["Period"]);
            if (array_key_exists('InvoiceDate', $invoice))
                $newinvoice->InvoiceDate = date($invoice["InvoiceDate"]);
            if (array_key_exists('InvoiceType', $invoice))
                $newinvoice->InvoiceType = strval($invoice["InvoiceType"]);

            if (array_key_exists('SelfBillingIndicator', $invoice["SpecialRegimes"]))
                $newinvoice->SpecialRegimes_SelfBillingIndicator = strval($invoice["SpecialRegimes"]["SelfBillingIndicator"]);
            if (array_key_exists('CashVATSchemeIndicator', $invoice["SpecialRegimes"]))
                $newinvoice->SpecialRegimes_CashVATSchemeIndicator = strval($invoice["SpecialRegimes"]["CashVATSchemeIndicator"]);
            if (array_key_exists('ThirdPartiesBillingIndicator', $invoice["SpecialRegimes"]))
                $newinvoice->SpecialRegimes_ThirdPartiesBillingIndicator = strval($invoice["SpecialRegimes"]["CashVATSchemeIndicator"]);

            if (array_key_exists('SourceID', $invoice))
                $newinvoice->SourceID = strval($invoice["SourceID"]);
            if (array_key_exists('SystemEntryDate', $invoice))
                $newinvoice->SystemEntryDate = strval($invoice["SystemEntryDate"]);
            if (array_key_exists('CustomerID', $invoice))
                $newinvoice->CustomerID = strval($invoice["CustomerID"]);

            if (array_key_exists('DeliveryDate', $invoice["ShipTo"]))
                $newinvoice->ShipTo_DeliveryDate = strval($invoice["ShipTo"]["DeliveryDate"]);

            if (array_key_exists('AddressDetail', $invoice["ShipTo"]["Address"]))
                $newinvoice->ShipTo_Address_AddressDetail = strval($invoice["ShipTo"]["Address"]["AddressDetail"]);
            if (array_key_exists('City', $invoice["ShipTo"]["Address"]))
                $newinvoice->ShipTo_Address_City = strval($invoice["ShipTo"]["Address"]["City"]);
            if (array_key_exists('PostalCode', $invoice["ShipTo"]["Address"]))
                $newinvoice->ShipTo_Address_PostalCode = strval($invoice["ShipTo"]["Address"]["PostalCode"]);
            if (array_key_exists('Country', $invoice["ShipTo"]["Address"]))
                $newinvoice->ShipTo_Address_Country = strval($invoice["ShipTo"]["Address"]["Country"]);

            if (array_key_exists('DeliveryDate', $invoice["ShipFrom"]))
                $newinvoice->ShipFrom_DeliveryDate = strval($invoice["ShipFrom"]["DeliveryDate"]);

            if (array_key_exists('AddressDetail', $invoice["ShipFrom"]["Address"]))
                $newinvoice->ShipFrom_Address_AddressDetail = strval($invoice["ShipFrom"]["Address"]["AddressDetail"]);
            if (array_key_exists('City', $invoice["ShipFrom"]["Address"]))
                $newinvoice->ShipFrom_Address_City = strval($invoice["ShipFrom"]["Address"]["City"]);
            if (array_key_exists('PostalCode', $invoice["ShipFrom"]["Address"]))
                $newinvoice->ShipFrom_Address_PostalCode = strval($invoice["ShipFrom"]["Address"]["PostalCode"]);
            if (array_key_exists('Country', $invoice["ShipFrom"]["Address"]))
                $newinvoice->ShipFrom_Address_Country = strval($invoice["ShipFrom"]["Address"]["Country"]);

            if (array_key_exists('MovementStartTime', $invoice))
                $newinvoice->MovementStartTime = strval($invoice["MovementStartTime"]);

            if (array_key_exists('TaxPayable', $invoice["DocumentTotals"]))
                $newinvoice->DocumentTotals_TaxPayable = strval($invoice["DocumentTotals"]["TaxPayable"]);
            if (array_key_exists('NetTotal', $invoice["DocumentTotals"]))
                $newinvoice->DocumentTotals_NetTotal = strval($invoice["DocumentTotals"]["NetTotal"]);
            if (array_key_exists('GrossTotal', $invoice["DocumentTotals"]))
                $newinvoice->DocumentTotals_GrossTotal = strval($invoice["DocumentTotals"]["GrossTotal"]);

            if (array_key_exists('WithholdingTaxAmount', $invoice["WithholdingTax"]))
                $newinvoice->WithholdingTax_WithholdingTaxAmount = strval($invoice["WithholdingTax"]["WithholdingTaxAmount"]);
                
                
/*
        foreach ($invoice["Line"] as $line){
            if(gettype($line) === 'array')
            {
                $newLine = new Lines;
                $newLine->InvoiceNo = $newinvoice->InvoiceNo;

                if (array_key_exists('ProductCode', $line))
                    $newLine->ProductCode = strval($line["ProductCode"]);
                if (array_key_exists('ProductDescription', $line))
                    $newLine->ProductDescription = strval($line["ProductDescription"]);
                if (array_key_exists('Quantity', $line))
                    $newLine->Quantity = strval($line["Quantity"]);
                if (array_key_exists('UnitOfMeasure', $line))
                    $newLine->UnitOfMeasure = strval($line["UnitOfMeasure"]);
                if (array_key_exists('UnitPrice', $line))
                    $newLine->UnitPrice = strval($line["UnitPrice"]);
                if (array_key_exists('TaxPointDate', $line))
                    $newLine->TaxPointDate = strval($line["TaxPointDate"]);
                if (array_key_exists('Description', $line))
                    $newLine->Description = strval($line["Description"]);
                if (array_key_exists('CreditAmount', $line))
                    $newLine->CreditAmount = strval($line["CreditAmount"]);

                if(array_key_exists('Tax', $line))
                {
                    if (array_key_exists('TaxType', $line["Tax"]))
                        $newLine->Tax_TaxType = strval($line["Tax"]["TaxType"]);
                    if (array_key_exists('TaxCountryRegion', $line["Tax"]))
                        $newLine->Tax_TaxCountryRegion = strval($line["Tax"]["TaxCountryRegion"]);
                    if (array_key_exists('TaxCode', $line["Tax"]))
                        $newLine->Tax_TaxCode = strval($line["Tax"]["TaxCode"]);
                    if (array_key_exists('TaxPercentage', $line["Tax"]))
                        $newLine->Tax_TaxPercentage = strval($line["Tax"]["TaxPercentage"]);
                }

                if (array_key_exists('SettlementAmount', $line))
                    $newLine->SettlementAmount = strval($line["SettlementAmount"]);

                $newLine->save();

            }
        }*/

            $newinvoice->save();
        }



        //save XML in db
        return redirect('/home')->with('success', 'Database is now updated according to SAFT');
    }
}
