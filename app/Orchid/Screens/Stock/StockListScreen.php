<?php


namespace App\Orchid\Screens\Stock;

use App\Models\Stock;
use App\Orchid\Layouts\Stock\StockListLayouts;
use App\Orchid\Layouts\Stock\StockImportLayout;
use App\Orchid\Layouts\Stock\EquipmentStatusEditLayout;
use App\Orchid\Layouts\Stock\RemarkCPELayout;
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

class StockListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'stocks' => Stock::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Stock';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */

    public function description(): ?string
    {
        return 'CPE management system';
    }

    public function commandBar(): iterable
    {
        return [
            
            Link::make('Download')
                ->icon('bs.download')
                ->method('get')
                ->route('platform.store.export'),
            ModalToggle::make(__('Import Excel'))
                ->icon('bs.plus-circle')
                ->modal('asyncImportStockModal')
                ->method('post')
                ->route('platform.store.import'),
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
            StockListLayouts::class,
            Layout::modal('asyncImportStockModal', StockImportLayout::class)
                ->title('Import Excel'),
            Layout::modal('asyncEditStockModal', EquipmentStatusEditLayout::class)
                ->async('asyncGetStockModal'),
            Layout::modal('asyncEditRemarkModal', RemarkCPELayout::class)
                ->async('asyncGetStockModal'),

        ];
    }

    public function asyncGetStockModal(Stock $stock): iterable
    {
        return [
            'stock' => $stock,
        ];
    }

    public function saveRemark(Request $request, Stock $stock): void
    {
        $stock->fill($request->input('stock'))->save();
        Toast::info(__('Stock Updated.'));
    }

    public function saveStock(Request $request, Stock $stock): void
    {
        $stockreq = $request->input('stock');
        if($stockreq['installation_order_no']){
            $stock->equipment_status = 'INSTALLED';
            $stock->installation_order_no = $stockreq['installation_order_no'];
            $stock->remark = '';
            $stock->save();
            Toast::info(__('Stock Updated.'));
        }else
            Toast::info(__('No changes.'));
        
    }
}
