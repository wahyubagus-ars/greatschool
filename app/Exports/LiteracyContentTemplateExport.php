<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LiteracyContentTemplateExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        return collect([
            [
                'Introduction to Programming',
                'article',
                'Technology',
                'Python is a high-level programming language...',
                '',
                'https://example.com/python-thumb.jpg',
                'blog',
                'py-101',
                'Featured content'
            ],
            [
                'Advanced JavaScript Tutorial',
                'video',
                'Programming',
                '',
                'https://youtube.com/watch?v=xyz789',
                'https://img.youtube.com/vi/xyz789/maxresdefault.jpg',
                'youtube',
                'xyz789',
                'Popular video'
            ],
            [
                'Digital Marketing Basics',
                'article',
                'Marketing',
                'Learn the fundamentals of digital marketing...',
                '',
                'https://example.com/marketing-thumb.jpg',
                'medium',
                'dm-202',
                ''
            ]
        ]);
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
            'Notes'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('FFEEEEEE');

        // Data validation for Type column
        $sheet->setDataValidation('B2:B501', 'article,video');

        // Data validation for Platform column
        $sheet->setDataValidation('G2:G501', 'youtube,vimeo,coursera,udemy,medium,blog,other');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(25);

        // Wrap text for content column
        $sheet->getStyle('D2:D501')->getAlignment()->setWrapText(true);

        return [
            'A1:I1' => [
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
        return 'Literacy Content';
    }
}
