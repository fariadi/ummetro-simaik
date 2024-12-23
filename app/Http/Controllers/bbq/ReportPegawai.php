<?php

namespace App\Http\Controllers\bbq;

use Illuminate\Http\Request;
use App\Helpers\RequestFilterHelper;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Repositories\Bbq\BbqregRepository;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportPegawai
{
    public function reportBbqExcel(Request $request, BbqregRepository $bbqregRepository)
    {

        $filterField = [
            'pegawai_id' => 'pegawai_id',
            'mentor_user_id' => 'mentor_user_id',
        ];
        $isFiltered = RequestFilterHelper::fieldKey($filterField, $request->all());
        $data = $bbqregRepository->countPegawaiSurat($isFiltered);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //header 
        $sheet->setCellValue('A2', 'LAPORAN BBQ PEGAWAi');
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'NAMA LENGKAP');
        $sheet->setCellValue('B4', 'NBM');
        $sheet->setCellValue('C4', 'MENTOR');
        $sheet->setCellValue('D4', 'AJUAN SURAT');
        $sheet->setCellValue('E4', 'DIVALIDASI');

        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->getRowDimension(4)->setRowHeight(30);

        $sheet->getStyle('A4:E4')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                    'color' => ['argb' => 'ff000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'font' => [
                'bold' => true,
            ]
        ]);

        $rowNumber = 5;
        foreach ($data as $row) {
            // dd($row->mentor_bbq->mentor->name);
            // dd($mentor);
            $sheet->setCellValue('A' . $rowNumber, $row->nama_lengkap);
            $sheet->setCellValue('B' . $rowNumber, $row->nbm ?? '');
            $sheet->setCellValue('C' . $rowNumber, $row->mentor_bbq->mentor->name ?? '');
            $sheet->setCellValue('D' . $rowNumber, $row->ajuan);
            $sheet->setCellValue('E' . $rowNumber, $row->divalidasi);

            $sheet->getStyle('A' . $rowNumber . ':E' . $rowNumber)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'ff000000'],
                    ],
                ],

                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ]

            ]);

            $sheet->getRowDimension($rowNumber)->setRowHeight(20);

            $rowNumber++;
        }
        $writer = new Xlsx($spreadsheet);
        $fileName = "data-bbq-pegawai.xlsx";
        $writer->save($fileName);

        // return Excel::download($fileName);
        return Response::download($fileName)->deleteFileAfterSend(true);
    }

    public function export()
    {
        //
    }
}
