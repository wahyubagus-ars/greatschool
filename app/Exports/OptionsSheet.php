<?php

namespace App\Exports;



use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OptionsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        return collect([
            [
                'Bullying di Sekolah',
                'Apa yang dimaksud dengan bullying?',
                'Perilaku menyakiti orang lain secara sengaja',
                'Yes',
                '1'
            ],
            [
                'Bullying di Sekolah',
                'Apa yang dimaksud dengan bullying?',
                'Bercanda biasa',
                'No',
                '2'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Quiz Title',
            'Question Text',
            'Option Text',
            'Is Correct',
            'Display Order'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('FFEEEEEE');

        // Data validation for Is Correct
        $sheet->setDataValidation('D2:D501', 'Yes,No');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(15);

        // Wrap text for option column
        $sheet->getStyle('C2:C501')->getAlignment()->setWrapText(true);

        return [
            'A1:E1' => [
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
        return 'Options';
    }
}
