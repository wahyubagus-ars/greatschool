<?php

namespace App\Exports;



use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InstructionsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        return collect([
            ['Instructions'],
            [''],
            ['1. Pastikan Quiz Title sama persis antar sheet.'],
            ['2. Gunakan format tanggal YYYY-MM-DD HH:MM.'],
            ['3. Question Type: multiple_choice, true_false, short_answer'],
            ['4. Setiap soal harus punya minimal 1 jawaban benar.'],
            ['5. Jangan ubah struktur kolom.'],
            [''],
            ['Important Notes:'],
            ['• Quizzes sheet must be processed first'],
            ['• Questions sheet references Quiz Title from Quizzes sheet'],
            ['• Options sheet references Quiz Title and Question Text from Questions sheet'],
            ['• Maximum 500 rows per sheet']
        ]);
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        // Format instructions
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Format numbered list
        $sheet->getStyle('A3:A7')->getFont()->setBold(true);

        // Format important notes
        $sheet->getStyle('A9:A13')->getFont()->setBold(true);

        return [];
    }

    public function title(): string
    {
        return 'Instructions';
    }
}
