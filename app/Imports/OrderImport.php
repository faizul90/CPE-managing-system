<?php

namespace App\Imports;

use App\Models\WorkOrderUnifi;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

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
        $date_transferred = $this->convertToDatabaseDateFormat($row['date_transferred']);

        $existingOrder = WorkOrderUnifi::where('order_no', $row['order_no'])->first();

        if ($existingOrder) {
            $existingOrder->batch = $row['batch'];
            $existingOrder->order_no = $row['order_no'];
            $existingOrder->team_id = $row['team_id'];
            $existingOrder->source_system = $row['source_system'];
            $existingOrder->transaction_type = $row['transaction_type'];
            $existingOrder->consumption_type = $row['consumption_type'];
            $existingOrder->exchange_code = $row['exchange_code'];
            $existingOrder->segment_group = $row['segment_group'];
            $existingOrder->status = 'Installed';
            $existingOrder->order_status = 'Installed';
            $existingOrder->date_transferred = $date_transferred;
            if($existingOrder->remarks === 'What status?')
            {
                $existingOrder->remarks = '';
            }else{
                null;
            }
            
            $existingOrder->save();
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
