<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class PatientListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'patients';

    /**
     * @return TD[]
     */
    protected function columns() : array
    {
        return [
            TD::make('name'),
            TD::make('created_at')->sort(),
        ];
    }
}