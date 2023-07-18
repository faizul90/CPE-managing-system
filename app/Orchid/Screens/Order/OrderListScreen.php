<?php

namespace App\Orchid\Screens\Order;

use App\Models\WorkOrderUnifi;
use App\Orchid\Layouts\Order\OrderListLayout;
use App\Orchid\Layouts\Order\OrderImportLayout;
use App\Orchid\Layouts\Order\OrderEditLayout;
use App\Http\Controllers\OrderImportExportController;
use Orchid\Screen\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Color;

class OrderListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'orders' => WorkOrderUnifi::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    public function description(): ?string
    {
        return 'Work Order System';
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Work Order';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make(__('Add Order'))
                ->icon('bs.plus-circle')
                ->modal('asyncAddOrderModal')
                ->modalTitle('Add Order')
                ->method('addOrder'),
            Link::make('Download')
                ->icon('bs.download')
                ->method('get')
                ->route('platform.order.export'),
            ModalToggle::make(__('Import Before Excel'))
                ->icon('bs.plus-circle')
                ->modal('asyncImportOrderBeforeModal')
                ->method('post')
                ->route('platform.order.importBefore'),
            ModalToggle::make(__('Import Excel'))
                ->icon('bs.plus-circle')
                ->modal('asyncImportOrderModal')
                ->method('post')
                ->route('platform.order.import'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            OrderListLayout::class,
            Layout::modal('asyncImportOrderModal', OrderImportLayout::class)
                ->title('Import Excel'),
            Layout::modal('asyncImportOrderBeforeModal', OrderImportLayout::class)
                ->title('Import Before Install Excel'),
            Layout::modal('asyncEditOrderModal', OrderEditLayout::class)
                ->async('asyncGetOrderModal'),
            Layout::modal('asyncAddOrderModal', OrderEditLayout::class)
                ->async('asyncGetOrderModal'),
        ];
    }

    public function asyncGetOrderModal(WorkOrderUnifi $order): iterable
    {
        return [
            'order' => $order,
        ];
    }

    public function addOrder(Request $request, WorkOrderUnifi $order)
    {
        $orderNumber = $request->input('order.order_no');

        // Check if the order number already exists
        $existingOrder = WorkOrderUnifi::where('order_no', $orderNumber)->first();
        if (empty($orderNumber)) {
            Toast::error(__('Order number is required.'));
        }else{
            if ($existingOrder) {
                Toast::info(__('Order Skipped. Order number already exists.'));
            } else {
                $order->fill($request->input('order'))->save();
                Toast::info(__('Order Added.'));
            }
        }
        
    }

    public function saveOrder(Request $request, WorkOrderUnifi $order)
    {
        $orderNumber = $request->input('order.order_no');

        if (empty($orderNumber)) {
            Toast::error(__('Order number is required.'));
        }else{
            $order->fill($request->input('order'))->save();
            Toast::info(__('Order Updated.'));
        }
        
    }

    public function remove(Request $request): void
    {
        WorkOrderUnifi::findOrFail($request->get('id'))->delete();

        Toast::info(__('Order was removed'));
    }
}
