<?php

namespace App\Models;

use App\Orchid\Presenters\UnifiInstallerIDPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;


class Unifiinstallerid extends Model
{
    use HasFactory, Filterable, AsSource;

    protected $fillable = [
        'team_id',
        'owner',
        'site',
        'remarks',
    ];

    protected $allowedFilters = [
        'id'        => Where::class,
        'team_id'   => Where::class,
        'owner'     => Where::class,
        'site'      => Where::class,
        'remarks'   => Where::class,
    ];

    protected $allowedSorts = [
        'team_id',
        'owner',
        'site',
        'remarks',
    ];

    public function presenter()
    {
        return new UnifiInstallerIDPresenter($this);
    }
}
