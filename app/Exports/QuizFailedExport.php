<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class QuizFailedExport implements FromCollection, WithHeadings, WithStyles, WithTitle
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
            $row['sheet'] = $failure['sheet'] ?? 'Unknown';
            $row['row_number'] = $failure['row'];

            $data[] = $row;
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Quiz Title',
            'Description',
            'Points Per Quiz',
            'Start Date',
            'End Date',
            'Duration (Minutes)',
            'Category',
            'Question Text',
            'Question Type',
            'Display Order',
            'Option Text',
            'Is Correct',
            'Sheet',
            'Row Number',
            'Errors'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:O1')->getFont()->setBold(true);
        $sheet->getStyle('A1:O1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:O1')->getFill()->getStartColor()->setARGB('FFEEEEEE');

        // Error highlighting
        $sheet->getStyle("A2:O" . (count($this->failedRows) + 1))->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFF0F0');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(10);
        $sheet->getColumnDimension('O')->setWidth(40);

        return [
            'A1:O1' => [
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
