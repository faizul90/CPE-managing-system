<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OrderImport;
use App\Imports\ImportBeforeInstallOrder;
use App\Exports\ExportOrder;
use App\Models\WorkOrderUnifi;
use App\Models\Unifiinstallerid;
use App\Models\Stock;
use Orchid\Filters;
use Carbon\Carbon;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Storage;

class OrderImportExportController extends Controller
{
    public $request;
    public $parameters;

    public function import(Request $request)
    {
        $excel = $request->file('file');
        
        foreach ($excel as $ex) {
            // try {
                $filePath = $ex->store('files');
                

                Excel::import(new OrderImport, $filePath);

                $rows = Excel::toArray(new OrderImport, $ex);

                if (empty($rows[0])) {
                    // Data is null, display toast message and continue to the next file
                    Toast::warning(__('Empty file: ' . $ex->getClientOriginalName()));
                    continue;
                }

                $serialNumbers = [];
                $batch = null;
                $orderNo = null;
                $date_install = null;

                foreach ($rows[0] as $row) {
                    if(isset($row['serial_number'])){
                        $serialNumbers[] = $row['serial_number'];
                        $batch = $row['batch'];
                        $orderNo = $row['order_no'];
                        $date_install = Carbon::createFromFormat('dmY', $row['service_start_date'])->format('Y-m-d');
                    }else{
                        continue;
                    }
                    

                }
                //dd($serialNumbers);
                Stock::whereIn('serial_no', $serialNumbers)
                    ->update([
                        'equipment_status' => 'INSTALLED',
                        'status' => 'DONE',
                        'batch' => $batch,
                        'installation_order_no' => $orderNo,
                        'installation_date' => $date_install,
                    ]);
                Storage::delete($filePath);
                Toast::info(__('Import successful: ' . $ex->getClientOriginalName()));
            // } catch (\Exception $e) {
            //     // Error occurred while reading the file, display toast message
            //     Toast::error(__('Error importing file: ' . $ex->getClientOriginalName()));
            // }
        }

        return redirect()->back();
    }

    public function importBefore(Request $request)
    {
        $excel = $request->file('file');
        foreach ($excel as $ex) {
            $filePath = $ex->store('files');
            Excel::import(new ImportBeforeInstallOrder, $filePath);
        }
        return redirect()->back();

    }

    public function export(Request $request){
        $date = Carbon::now();
        return Excel::download(new ExportOrder, 'order'.$date.'.xlsx');
    }

    
}
