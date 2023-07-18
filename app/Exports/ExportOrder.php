<?php

namespace App\Exports;

use App\Models\WorkOrderUnifi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Orchid\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style;
use PhpOffice\PhpSpreadsheet\Style\Style as DefaultStyles;

class ExportOrder implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, ShouldAutoSize
{

    use Exportable;

    protected $index = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $parsedUrl = parse_url(str_replace(url('/'), '', url()->previous()));
        $order = WorkOrderUnifi::query();

        if (empty($parsedUrl['query'])) {
            $test = 'no data';
            $order = $order->get();
        } else {
            $test = $parsedUrl['query'];

            parse_str($test, $output);
            if (!empty($output['filter'])) {
                $filter = $output['filter'];

                $order = $order->where(function ($query) use ($filter) {
                    foreach ($filter as $key => $value) {
                        $query->where(function ($query) use ($key, $value) {
                            if (isset($value)) {
                                $query->where($key, 'LIKE', '%' . $value . '%');
                            } else {
                                $query->where($key, 'LIKE', '%' . '' . '%')
                                    ->orWhereNull($key);
                            }
                        });
                    }
                });

                $order = $order->get();
            } else {
                $order = $order->get();
            }
        }

        return $order;
    }

    public function map($row): array {
        return [
            ++$this->index,
            $row['order_no'],
            $row['team_id'],
            $row['transaction_type'],
            $row['source_system'],
            $row['consumption_type'],
            $row['exchange_code'],
            $row['segment_group'],
            $row['batch'],
            $row['date_transferred'],
            $row['remarks'],
        ];
    }

    public function headings(): array
    {
        return ["#", "Order No.", "Team ID", "Transaction Type", "Source System", "Consumption Type", "Exchange Code", "Segment Group", "Batch", "DATE TRANSFERRED", "Remark"];
    }

    public function columnWidths(): array {
        return [
            'B'=> 25
        ];
    }

    public function styles(Worksheet $sheet) {
        // return [
        //     '1' => ['font' => ['bold' => true]],
        // ];
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }

    public function defaultStyles(DefaultStyles $defaultStyle)
    {
        return [
            'font' => [
                'name' => 'Calibri',
                'size' => 12
            ],
            'alignment' => [
                'horizontal' => Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => Style\Alignment::VERTICAL_CENTER,
            ],
        ];
    }

}
