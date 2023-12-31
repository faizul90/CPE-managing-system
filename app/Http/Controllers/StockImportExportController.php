<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportStock;
use App\Exports\ExportStock;
use App\Models\Stock;
use Orchid\Filters;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Storage;

class StockImportExportController extends Controller
{
    //
    public $request;
    public $parameters;

    public function import(Request $request)
    {
        try {
            $excel = $request->file('file');
            $filePath = $excel->store('files');

            Excel::import(new ImportStock, $filePath);

            $rows = Excel::toArray(new ImportStock, $excel);

            $serials = array_column($rows[0], 'serial_no');

            $updatedStocks = Stock::whereIn('serial_no', $serials)->get();

            foreach ($rows[0] as $row) {

                $stock = Stock::where('serial_no', $row['serial_no'])->first();

                if ($stock) {
                    if(isset($row['status'])){
                        if($row['equipment_status'] === 'NEW' && $row['status'] === 'NOT UPDATE'){
                            $stock->status = '';
                        }else{
                            $stock->status = $row['status'];
                        }
                    }
                    
                    $stock->batch = $row['batch'];
                    $stock->equipment_status = $row['equipment_status'];
                    $stock->reason = $row['reason'];
                    $stock->valuation_type = $row['valuation_type'];
                    $stock->save();
                }
            }

            $notUpdatedStocks = Stock::whereNotIn('serial_no', $serials)->get();

            foreach ($notUpdatedStocks as $stock) {
                $status = '';

                switch ($stock->equipment_status) {
                    case 'NEW':
                        $status = 'NOT UPDATE';
                        break;
                    case 'INSTALLED':
                        $status = 'DONE';
                        break;
                    case 'PENALTY':
                    case 'DOA':
                        $status = 'REMOVE IN TM SYSTEM';
                        break;
                }

                if ($status !== '') {
                    $stock->status = $status;
                    $stock->save();
                }
            }
            Storage::delete($filePath);
            Toast::info(__('Import completed successfully!'));
        } catch (\Exception $e) {
            Log::error($e);
            Toast::error(__('Error importing file: ' . $excel->getClientOriginalName()));
        }

        return redirect()->back();
    }

    public function export(Request $request){
        $date = Carbon::now();
        return Excel::download(new ExportStock, 'cpe'.$date.'.xlsx');
    }
}
