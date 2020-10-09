<?php

namespace App\Http\Controllers;

use App\Imports\ProductSalesImport;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function import(Request $request)
    {
        $import_action = $request['import_action'];
        $import_response = null;

        if ($request->hasFile('document')) {
            $document = $request->file('document');

            switch ($import_action) {
                case 'import_products':
                    $import = new ProductsImport();
                    break;
                case 'import_product_sales':
                    $import = new ProductSalesImport();
                    break;
                default:
                    return abort(500);
                    break;
            }

            Excel::import($import, $document);
            $import_response = $import->data;

            return redirect()->back()
                ->with($import_response['status'], $import_response['message']);
        }
    }
}
