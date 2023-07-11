<?php

namespace App\Orchid\Layouts\Order;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;


class OrderEditLayout extends Rows
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
            Input::make('order.order_no')
                ->type('text')
                ->max(255)
                ->title(__('Order No'))
                ->placeholder(__('Order No')),

            Input::make('order.team_id')
                ->type('text')
                ->max(255)
                ->title(__('Team ID'))
                ->placeholder(__('Team ID')),

            Input::make('order.date_transferred')
                ->type('text')
                ->max(255)
                ->title(__('Date Transferred'))
                ->placeholder(__('Date Transferred')),

            Input::make('order.transaction_type')
                ->type('text')
                ->max(255)
                ->title(__('Transaction Type'))
                ->placeholder(__('Transaction Type')),

            Input::make('order.remarks')
                ->type('text')
                ->max(255)
                ->title(__('Remark'))
                ->placeholder(__('Remark')),
        ];
    }
}
