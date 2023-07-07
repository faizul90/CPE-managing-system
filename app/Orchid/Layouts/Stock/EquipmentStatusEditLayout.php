<?php

namespace App\Orchid\Layouts\Stock;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class EquipmentStatusEditLayout extends Rows
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
            Input::make('stock.equipment_status')
                ->type('text')
                ->max(255)
                ->title(__('Equipment Status'))
                ->placeholder(__('Equipment Status')),

            Input::make('stock.installation_order_no')
                ->type('text')
                ->max(255)
                ->title(__('INSTALLATION ORDER NO'))
                ->placeholder(__('INSTALLATION ORDER NO')),
        ];
    }
}
