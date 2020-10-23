<?php

namespace App\Http\Controllers;

use App\Exports\ReportsExport;
use App\Models\Branch\Branch;
use App\Models\Inventory\InventoryMovement;
use App\Models\Product\Product;
use App\Models\Product\ProductOrder;
use App\Models\Product\ProductSale;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return view('reports.index', compact('branches'));
    }

    public function generate(Request $request)
    {
        $input = $request->all();

        /* Date Validations */
        if ($input['date_from'] && $input['date_to']) {
            $from_date = Carbon::createFromFormat('m/d/Y', $input['date_from'])->format('Y-m-d');
            $to_date = Carbon::createFromFormat('m/d/Y', $input['date_to'])->format('Y-m-d');

            if ($from_date > $to_date) {
                $message = 'Please check your date field values.';
                return redirect()->route('reports.index')->with('error', $message);
            }
        } else {
            $from_date = null;
            $to_date = null;
        }

        $detail_collection = $this->reportsQuery($input, $from_date, $to_date);
        $date_printed = Carbon::now();
        $report_details = [
            'report' => 'stock_movement',
            'title' => 'Stock Movement Report',
        ];

        $input['branch_name'] = Branch::find($input['branch_id'])->name;

        switch ($request['action']) {
            case 'excel':
                $file_name = $report_details['report'];
                $detail_collection = $detail_collection->map(function ($detail) {
                    return [
                        'product_name' => $detail->product_name,
                        'product_type' => $detail->product_type,
                        'movement_type' => $detail->movement_type,
                        'quantity' => $detail->quantity,
                        'r_quantity' => $detail->r_quantity,
                        'created_at' => $detail->created_at
                    ];
                });
                $header = ['Item Name', 'Product Type', 'Movement Type', 'Quantity', 'Running Quantity', 'Transaction Date'];
                return Excel::download(new ReportsExport($detail_collection, $header), $file_name . '.xlsx');
                break;
            case 'pdf':
                $detail_collection = $detail_collection->groupBy(['product_type', 'product_name']);
                $print = PDF::loadView('reports.reports_main', compact(
                    'input',
                    'report_details',
                    'date_printed',
                    'detail_collection'
                ))->setPaper('a4', 'portrait');

                return $print->stream($report_details['report'] . '_' . Carbon::now()->format('YmdHis') . '.pdf');
                break;
        }
    }

    public function reportsQuery($input, $from_date, $to_date)
    {
        $inventory_movements = DB::table('inventory_movements')
            ->when($from_date != null && $to_date != null, function ($query) use ($from_date, $to_date) {
                return $query->whereBetween('inventory_movements.created_at', [$from_date, $to_date]);
            })
            ->orderBy('inventory_movements.created_at', 'desc')
            ->get();

        foreach ($inventory_movements as $key => $inventory_movement) {

            $transaction = collect();
            if ($inventory_movement->type == InventoryMovement::$order) {
                $transaction = ProductOrder::withTrashed()->find($inventory_movement->tx_id);
                $inventory_movement->movement_type = 'Product Order';
            } else if ($inventory_movement->type == InventoryMovement::$sale) {
                $transaction = ProductSale::withTrashed()->find($inventory_movement->tx_id);
                $inventory_movement->movement_type = 'Product Sale';
            }

            if ($transaction->branch_id == $input['branch_id']) {
                $product = Product::withTrashed()->find($transaction->product_id);
                $branch = Branch::withTrashed()->find($transaction->branch_id);

                $inventory_movement->branch_name = $branch->name;
                $inventory_movement->product_name = $product->name;
                $inventory_movement->product_type = $product->productType->type;
            } else {
                $inventory_movements->forget($key);
            }
        }

        return $inventory_movements;
    }
}
