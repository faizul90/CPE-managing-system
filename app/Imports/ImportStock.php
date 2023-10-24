<?php

namespace App\Imports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;


class ImportStock implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;

    // public function startRow(): int
    // {
    //     return 2;
    // }
    public function model(array $row)
    {
        
        $aging = 'NEW';

        $warranty_start = $this->convertToDatabaseDateFormat($row['warranty_start_date']);
        $warranty_end = $this->convertToDatabaseDateFormat($row['warranty_end_date']);
        $currentTime = Carbon::now();

        $existingStock = Stock::where('serial_no', $row['serial_no'])->first();
        
        if ($existingStock) {
            $today = Carbon::today()->subMonths(3)->toDateString();
            $today2 = Carbon::today()->subMonths(7)->toDateString();
            $today3 = Carbon::today()->subMonths(12)->toDateString();

            if ($warranty_start < $today) {
                $aging = 'AGING 3 MONTH';
            } if ($warranty_start < $today2) {
                $aging = 'AGING 7 MONTH';
            } if ($warranty_start < $today3) {
                $aging = 'AGING 1 YEAR';
            }
            
            $existingStockWarrantyStart = $this->convertToDatabaseDateFormat($existingStock->warranty_start);
            $existingStockWarrantyEnd = $this->convertToDatabaseDateFormat($existingStock->warranty_end);
            $existingStock->updated_at = $currentTime;
            $existingStock->batch = $row['batch'];
            $existingStock->aging = $aging;

            if ($existingStockWarrantyStart === $warranty_start && $existingStockWarrantyEnd === $warranty_end && $row['remark'] = '') {
                return null; // Skip insertion if the date values are the same as in the database
            }else{
                $existingStock->warranty_start = $warranty_start;
                $existingStock->warranty_end = $warranty_end;
            }
            
            return $existingStock;// Update insertion if serial_no already exists
        } else {
            return new Stock([
                'batch' => $row['batch'],
                'material_no' => $row['material_no'],
                'description' => $row['description'],
                'serial_no' => $row['serial_no'],
                'equipment_status' => $row['equipment_status'],
                'valuation_type' => $row['valuation_type'],
                'reason' => $row['reason'],
                'aging' => $aging,
                'installation_order_no' => $row['installation_order_no'],
                'installation_date' => $row['installation_order_date'],
                'warranty_start' => $warranty_start,
                'warranty_end' => $warranty_end,
                'updated_at' => $currentTime->toDateTimeString(),
                'status' => '',
                'remark' => '',
            ]);
        }
        dd();
    }

    private function convertToDatabaseDateFormat($date)
    {
        $date = trim($date); // Remove leading/trailing spaces

        if (is_numeric($date)) {
            return ExcelDate::excelToDateTimeObject($date)->format('Y-m-d H:i:s');
        } elseif ($date != null) {
            // If the date matches the 'Y-m-d H:i:s' format, return the same format
            return $date;
        } else {
            return null;
        }
    }
}
