<?php

namespace App\Orchid\Layouts\Stock;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Upload;

class StockImportLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('raw_file')
                ->type('file')
                ->name('file')
                ->title('File input example')
                ->horizontal(),
        ];
    }
}
