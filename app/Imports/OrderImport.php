<?php

namespace App\Imports;

use App\Models\WorkOrderUnifi;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrderImport implements ToModel, WithHeadingRow
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
        $date_transferred = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_transferred'])->format('Y-m-d H:i:s');

        $existingOrder = WorkOrderUnifi::where('order_no', $row['order_no'])->first();

        if ($existingOrder) {
            return null;
        }else{
            return new WorkOrderUnifi([
                'order_no'          => $row['order_no'],
                'team_id'           => $row['team_id'],
                'date_transferred'  => $date_transferred,
                'source_system'     => $row['source_system'],
                'transaction_type'  => $row['transaction_type'],
                'consumption_type'  => $row['consumption_type'],
                'exchange_code'     => $row['exchange_code'],
                'segment_group'     => $row['segment_group'],
                'batch'             => $row['batch'],
                'remarks'           => '',
            ]);
        }
        
    }
}
