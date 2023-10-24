<?php

namespace App\Imports;

use App\Models\Workorderunifi;
use App\Models\Unifiinstallerid;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportBeforeInstallOrder implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $planned_start = $this->excelToDateTimeString($row['planned_start'] ?? null);
        $created = $this->excelToDateTimeString($row['created'] ?? null);

        $team = Unifiinstallerid::all()->pluck('team_id')->toArray();
        
        if (in_array($row['swift_team_id'], $team)) {
            $existingOrder = WorkOrderUnifi::where('order_no', $row['order'])->first();

            if ($existingOrder) {
                $updates = [
                    'account_name' => $row['account_name'] ?? null,
                    'team_id' => $row['swift_team_id'],
                    'platform' => $row['platform'],
                    'location_dp' => $row['location_dp'],
                    'type' => $row['type'],
                    'assignment_type' => $row['assignment_type'],
                    'status' => $row['status'],
                    'order_status' => $row['order_status'],
                    'created' => $created,
                    'product_name' => $row['product_name'] ?? null,
                    'segment_sub_group' => $row['segment_sub_group'] ?? null,
                    'planned_start' => $planned_start,
                ];
                $existingOrder->update($updates);
            } else {
                WorkOrderUnifi::create([
                    'order_no' => $row['order'],
                    'account_name' => $row['account_name'] ?? null,
                    'team_id' => $row['swift_team_id'],
                    'platform' => $row['platform'],
                    'location_dp' => $row['location_dp'],
                    'type' => $row['type'],
                    'assignment_type' => $row['assignment_type'],
                    'status' => $row['status'],
                    'order_status' => $row['order_status'],
                    'created' => $created,
                    'product_name' => $row['product_name'] ?? null,
                    'segment_sub_group' => $row['segment_sub_group'] ?? null,
                    'planned_start' => $planned_start,
                ]);
            }
        } else {
            return null;
        }
    }
        

    private function excelToDateTimeString($excelDate)
    {
        return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d H:i:s');
    }
}
