<?php

namespace App\Exports;

use App\Models\Stock;
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

class ExportStock implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, ShouldAutoSize
{
    use Exportable;

    protected $index = 0;

    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $parsedUrl = parse_url(str_replace(url('/'), '', url()->previous()));
        $Stock = Stock::query();

        if (empty($parsedUrl['query'])) {
            $test = 'no data';
            $Stock = $Stock->get();
        } else {
            $test = $parsedUrl['query'];

            parse_str($test, $output);
            if (!empty($output['filter'])) {
                $filter = $output['filter'];

                $Stock = $Stock->where(function ($query) use ($filter) {
                    $query->where('batch', 'LIKE', '%' . ($filter['batch'] ?? '') . '%')
                        ->where('material_no', 'LIKE', '%' . ($filter['material_no'] ?? '') . '%')
                        ->where('description', 'LIKE', '%' . ($filter['description'] ?? '') . '%')
                        ->where('serial_no', 'LIKE', '%' . ($filter['serial_no'] ?? '') . '%')
                        ->where('equipment_status', 'LIKE', '%' . ($filter['equipment_status'] ?? '') . '%')
                        ->where('valuation_type', 'LIKE', '%' . ($filter['valuation_type'] ?? '') . '%')
                        ->where('reason', 'LIKE', '%' . ($filter['reason'] ?? '') . '%')
                        ->where('aging', 'LIKE', '%' . ($filter['aging'] ?? '') . '%')
                        ->where('remark', 'LIKE', '%' . ($filter['remark'] ?? '') . '%');;
                });
                $Stock = $Stock->select('batch','material_no','description','serial_no','equipment_status','valuation_type','reason', 'aging', 'installation_order_no', 'installation_date', 'updated_at', 'warranty_start', 'warranty_end', 'remark');
                $Stock = $Stock->get();
            } else {
                $Stock = $Stock->get();
            }
        }

        return $Stock;
    }

    public function map($row): array {
        return [
            ++$this->index,
            $row['batch'],
            $row['material_no'],
            $row['description'],
            $row['serial_no'],
            $row['equipment_status'],
            $row['valuation_type'],
            $row['reason'],
            $row['aging'],
            $row['installation_order_no'],
            $row['installation_date'],
            $row['updated_at'],
            $row['warranty_start'],
            $row['warranty_end'],
            $row['remark'],
        ];
    }

    public function headings(): array
    {
        return ["#", "Batch", "Material No", "Description", "Serial No", "Equipment Status", "Valuation Type", "Reason", "AGING STATUS", "INSTALLATION ORDER NO", "INSTALLATION DATE", "Last edit", "Warranty Start Date", "Warranty End Date", "remark"];
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
