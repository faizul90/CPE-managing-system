<?php

namespace App\Orchid\Layouts\Stock;

use App\Models\Stock;
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

class StockListLayouts extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target = 'stocks';

    /**
     * @return TD[]
     */

    public function columns(): array
    {
        return [

            TD::make('batch', __('Batch'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => $stock->batch),

            TD::make('material_no', __('Material No'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => $stock->material_no),

            TD::make('description', __('Description'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => $stock->description),

            TD::make('serial_no', __('Serial No'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => $stock->serial_no),

            TD::make('equipment_status', __('Equipment Status'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => ModalToggle::make($stock->equipment_status)
                    ->modal('asyncEditRemarkModal')
                    ->modalTitle($stock->presenter()->title())
                    ->method('saveRemark')
                    ->asyncParameters([
                        'stock' => $stock->id,
                    ])),

            TD::make('valuation_type', __('Valuation Type'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => $stock->valuation_type),

            TD::make('reason', __('Reason'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => $stock->reason),

            TD::make('aging', __('AGING STATUS'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => $stock->aging),

            TD::make('installation_order_no', __('INSTALLATION ORDER NO'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => $stock->installation_order_no),

            TD::make('installation_date', __('INSTALLATION DATE'))
                ->sort()
                ->render(fn (Stock $stock) => $stock->installation_date),

            TD::make('updated_at', __('LAST EDIT'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => $stock->updated_at),

            TD::make('remark', __('REMARK'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Stock $stock) => ModalToggle::make($stock->remark)
                    ->modal('asyncEditRemarkModal')
                    ->modalTitle($stock->presenter()->title())
                    ->method('saveRemark')
                    ->asyncParameters([
                        'stock' => $stock->id,
                    ])),

            TD::make('warranty_start', __('Warranty Start'))
                ->sort()
                ->render(fn (Stock $stock) => $stock->warranty_start),

            TD::make('warranty_end', __('Warranty End'))
                ->sort()
                ->render(fn (Stock $stock) => $stock->warranty_end),

            

            /** TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Stock $stock) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.systems.stocks.edit', $stock->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'id' => $stock->id,
                            ]),
                    ])), **/
        ];
    }
}
