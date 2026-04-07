<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LiteracyContentFailedExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $failedRows;

    public function __construct(array $failedRows)
    {
        $this->failedRows = $failedRows;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->failedRows as $failure) {
            $row = $failure['data'];
            $row['errors'] = implode(', ', $failure['errors']);
            $row['row_number'] = $failure['row'];

            $data[] = $row;
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Title',
            'Type',
            'Category',
            'Content',
            'URL',
            'Thumbnail',
            'Platform',
            'Platform ID',
            'Notes',
            'Row Number',
            'Errors'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:L1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:L1')->getFill()->getStartColor()->setARGB('FFEEEEEE');

        // Error highlighting
        $errorColumn = count($this->headings());
        $sheet->getStyle("A2:L" . (count($this->failedRows) + 1))->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFF0F0');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('K')->setWidth(40);

        return [
            'A1:L1' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Failed Rows';
    }
}
