<?php

namespace App\Orchid\Layouts\Order;

use App\Models\WorkOrderUnifi;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Carbon\Carbon;
use Orchid\Support\Facades\Layout;

class OrderListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'orders';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('order_no', __('Order No'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->order_no),

            TD::make('team_id', __('Team ID'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->team_id),

            TD::make('date_transferred', __('Date Transferred'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->date_transferred),

            TD::make('source_system', __('Source System'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->source_system),

            TD::make('transaction_type', __('Transaction Type'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->transaction_type),

            TD::make('consumption_type', __('Consumption Type'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->consumption_type),

            TD::make('exchange_code', __('Exchange Code'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->exchange_code),

            TD::make('segment_group', __('Segment Group'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->segment_group),

            TD::make('batch', __('Batch'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->batch),

            TD::make('remarks', __('Remark'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->remarks),
        ];
    }
}
