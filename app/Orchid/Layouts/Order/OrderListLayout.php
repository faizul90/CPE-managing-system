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
                ->render(fn (WorkOrderUnifi $items) => ModalToggle::make($items->order_no)
                                ->modal('asyncEditOrderModal')
                                ->modalTitle($items->presenter()->title())
                                ->method('saveOrder')
                                ->asyncParameters([
                                    'order' => $items->id,
                                ])),

            TD::make('team_id', __('Team ID'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->team_id),

            TD::make('date_transferred', __('Date Transferred'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->date_transferred),

            TD::make('planned_start', __('Planned Start'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->planned_start),

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

            TD::make('segment_sub_group', __('Segment Sub Group'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->segment_sub_group),

            TD::make('batch', __('Batch'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->batch),
            //

            TD::make('account_name', __('Account Name'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->account_name),

            TD::make('platform', __('Platform'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->platform),

            TD::make('location_dp', __('Location DP'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->location_dp),

            TD::make('type', __('Type'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->type),

            TD::make('assignment_type', __('Assignment Type'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->assignment_type),

            TD::make('product_name', __('Product Name'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->product_name),

            TD::make('order_status', __('Order Status'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->order_status),

            TD::make('status', __('Status'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->status),


            //

            TD::make('remarks', __('Remark'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (WorkOrderUnifi $items) => $items->remarks),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (WorkOrderUnifi $items) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'id' => $items->id,
                            ]),
                    ])),
        ];
    }
}
