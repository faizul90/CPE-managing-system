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

        $existingOrder = WorkOrderUnifi::where('order_no', $row['order'])->first();
        $planned_start = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['planned_start'])->format('Y-m-d H:i:s');
        $created = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['created'])->format('Y-m-d H:i:s');

        if ($existingOrder) {
            $team = Unifiinstallerid::all()->toArray();
            foreach($team as $t){
                if($row['swift_team_id'] === $t['team_id']){
                    $existingOrder->account_name = $row['account_name'];
                    $existingOrder->team_id = $row['swift_team_id'];
                    $existingOrder->platform = $row['platform'];
                    $existingOrder->location_dp = $row['location_dp'];
                    $existingOrder->type = $row['type'];
                    $existingOrder->status = $row['status'];
                    $existingOrder->order_status = $row['order_status'];
                    $existingOrder->created = $created;
                    if(isset( $row['product_name'])){
                        $existingOrder->product_name = $row['product_name'];
                    }if(isset( $row['segment_sub_group'])){
                        $existingOrder->segment_sub_group = $row['segment_sub_group'];
                    }if(isset( $row['planned_start'])){
                        $existingOrder->planned_start = $planned_start;
                    }
                    $existingOrder->save();
                }else{
                    continue;
                }
            }
        }else{
            $team = Unifiinstallerid::all()->toArray();
            foreach($team as $t){
                $team_id[] = $t['team_id'];
            }
            foreach($team_id as $tt){
                $teamExist = WorkOrderUnifi::where('team_id', $tt)->first();
                if($row['swift_team_id'] === $tt){
                   $teamExist->order_no = $row['order'];
                    $teamExist->account_name = $row['account_name'];
                    $teamExist->team_id = $row['swift_team_id'];
                    $teamExist->platform = $row['platform'];
                    $teamExist->location_dp = $row['location_dp'];
                    $teamExist->type = $row['type'];
                    $teamExist->status = $row['status'];
                    $teamExist->order_status = $row['order_status'];
                    $teamExist->created = $created;
                    if(isset( $row['product_name'])){
                        $teamExist->product_name = $row['product_name'];
                    }if(isset( $row['segment_sub_group'])){
                        $teamExist->segment_sub_group = $row['segment_sub_group'];
                    }if(isset( $row['planned_start'])){
                        $teamExist->planned_start = $planned_start;
                    }
                    $teamExist->save(); 
                }else{
                    return null;
                }
                
            }
            
        }
        
    }
}
