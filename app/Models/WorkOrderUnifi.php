<?php

namespace App\Models;

use App\Orchid\Presenters\WorkOrderPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;

class Workorderunifi extends Model
{
    use HasFactory, Filterable, AsSource;

    protected $fillable = [
        'order_no',
        'team_id',
        'date_transferred',
        'transaction_type',
        'source_system',
        'consumption_type',
        'exchange_code',
        'segment_group',
        'batch',
        'remarks',
        'planned_start',
        'account_name',
        'platform',
        'location_dp',
        'type',
        'status',
        'assignment_type',
        'order_status',
        'created',
        'product_name',
        'segment_sub_group',
    ];
            

    protected $allowedFilters = [
        'id'                => Where::class,
        'team_id'           => Like::class,
        'order_no'          => Like::class,
        'date_transferred'  => WhereDateStartEnd::class,
        'transaction_type'  => Like::class,
        'source_system'     => Like::class,
        'consumption_type'  => Like::class,
        'exchange_code'     => Like::class,
        'segment_group'     => Like::class,
        'batch'             => Like::class,
        'remarks'           => Like::class,
        'planned_start'     => WhereDateStartEnd::class,
        'account_name'      => Like::class,
        'platform'          => Like::class,
        'location_dp'       => Like::class,
        'type'              => Like::class,
        'status'            => Like::class,
        'assignment_type'   => Like::class,
        'order_status'      => Like::class,
        'created'           => Like::class,
        'product_name'      => Like::class,
        'segment_sub_group' => Like::class,
    ];

    protected $allowedSorts = [
        'id',
        'order_no',
        'team_id',
        'date_transferred',
        'transaction_type',
        'source_system',
        'consumption_type',
        'exchange_code',
        'segment_group',
        'batch',
        'remarks',
        'planned_start',
        'account_name',
        'platform',
        'location_dp',
        'type',
        'status',
        'assignment_type',
        'order_status',
        'created',
        'product_name',
        'segment_sub_group',
  
    ];

    public function presenter()
    {
        return new WorkOrderPresenter($this);
    }
}
