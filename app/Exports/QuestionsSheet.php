<?php

namespace App\Exports;



use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        return collect([
            [
                'Bullying di Sekolah',
                'Apa yang dimaksud dengan bullying?',
                'multiple_choice',
                '1'
            ],
            [
                'Bullying di Sekolah',
                'Contoh bullying verbal adalah...',
                'multiple_choice',
                '2'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Quiz Title',
            'Question Text',
            'Question Type',
            'Display Order'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getStyle('A1:D1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('FFEEEEEE');

        // Data validation for Question Type
        $sheet->setDataValidation('C2:C501', 'multiple_choice,true_false,short_answer');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);

        // Wrap text for question column
        $sheet->getStyle('B2:B501')->getAlignment()->setWrapText(true);

        return [
            'A1:D1' => [
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
        return 'Questions';
    }
}
