<?php

namespace App\Models;

use App\Orchid\Presenters\StockPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;

class Stock extends Model
{
    use HasFactory, Filterable, AsSource;

    protected $fillable = [
        'batch',
        'material_no',
        'description',
        'serial_no',
        'equipment_status',
        'valuation_type',
        'reason',
        'aging',
        'status',
        'remark',
        'installation_order_no',
        'installation_date',
        'warranty_start',
        'warranty_end',
        'updated_at',
    ];


    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
           'id'         => Where::class,
           'batch'       => Like::class,
           'material_no'      => Like::class,
           'description'       => Like::class,
           'serial_no'      => Like::class,
           'equipment_status'       => Like::class,
           'valuation_type'      => Like::class,
           'reason'       => Like::class,
           'aging'       => Like::class,
           'status'       => Like::class,
           'remark'       => Like::class,
           'installation_order_no'       => Like::class,
           'installation_date'      => WhereDateStartEnd::class,
           'warranty_start'      => WhereDateStartEnd::class,
           'warranty_end'      => WhereDateStartEnd::class,
           'updated_at' => Like::class,
           'created_at' => WhereDateStartEnd::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'batch',
        'material_no',
        'description',
        'serial_no',
        'equipment_status',
        'valuation_type',
        'reason',
        'aging',
        'status',
        'remark',
        'installation_order_no',
        'installation_date',
        'warranty_start',
        'warranty_end',
        'updated_at',
        'created_at',
    ];

    public function presenter()
    {
        return new StockPresenter($this);
    }
}
