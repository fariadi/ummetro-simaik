<?php

namespace App\Http\Controllers\bbq;
use App\Http\Controllers\Controller;
use App\Repositories\Bbq\BbqregRepository;
use App\Http\Requests\bbq\BbqregStore;
use App\Http\Requests\bbq\PertemuanStore;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use RequestFilterHelper;

class BbqregController extends Controller
{
  use ResponseTrait;

  public function store(BbqregStore $request, BbqregRepository $bbqregRepository)
  {
    try {
      $data = $bbqregRepository->create($request->all());
      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $exception) {
      return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function show(BbqregRepository $bbqregRepository, $id): JsonResponse
  {
    try {
      $data = $bbqregRepository->getByID($id);
      if (is_null($data)) {
        return $this->responseError(null, 'Data Not Found', Response::HTTP_NOT_FOUND);
      }
      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function dataTableJson(Request $request, BbqregRepository $bbqregRepository)
  {
    try {
      $colOrder = [
        1 => 'id',
        2 => 'id',
      ];
      $filterField = [
        'pegawai_id' => 'pegawai_id',
        'mentor_user_id' => 'mentor_user_id',
      ];
      $search  = ($request->input('search')) 
        ? $request->input('search') 
        : '';
      $search  = (is_array($search)) 
        ? $search['value'] 
        : $search;
      $orderField = isset($colOrder[$request->input('order.0.column')])
        ? $colOrder[$request->input('order.0.column')]
        : null;
      $isValidasi =  ($request->input('validasi')) 
        ? $request->input('validasi') 
        : '';
      $isFiltered = RequestFilterHelper::fieldKey($filterField, $request->all());
      if($isValidasi == 'show') {
        $isFiltered[] = ['mentor_validasi', '<>', null];
      }
      else {
        $isFiltered[] = ['mentor_validasi', '=', null];
      }
      
      $whereKeys = [
        'order'  => !empty($orderField) ? [$orderField, $request->input('order.0.dir')] : ['id', 'ASC'],
        'limit'  => $request->input('length'),
        'start'  => $request->input('start'),
        'search' => $search,
        'data'   => $isFiltered,
      ];

      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $bbqregRepository->totAll($whereKeys),
        'recordsFiltered' => $bbqregRepository->countFiltered($whereKeys),
        'code' => 200,
        'data' => $bbqregRepository->limitFiltered($whereKeys)
      ]);
    } catch (\Exception $e) {
      return response()->json(
        [
          'message' => $e->getMessage(),
          'code' => 500,
          'data' => [],
        ],
        Response::HTTP_INTERNAL_SERVER_ERROR
      );
    }
  }

  public function destroy(BbqregRepository $bbqregRepository, $id): JsonResponse
  {
    try {
      $data = $bbqregRepository->getByID($id);
      if (empty($data)) {
        return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
      }

      $deleted = $bbqregRepository->delete($id);
      if (!$deleted) {
        return $this->responseError(null, 'Failed to delete.', Response::HTTP_INTERNAL_SERVER_ERROR);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function pertemuanUpdate(PertemuanStore $request, BbqregRepository $bbqregRepository, $id)
  {
    try {
      $data = $bbqregRepository->update($id, $request->all());
      if (is_null($data)) {
        return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function mentorValidasi(Request $request, BbqregRepository $bbqregRepository, $id)
  {
    try {
      $value = $request->only(['mentor_validasi']);
      $data = $bbqregRepository->update($id, $value);
      if (is_null($data)) {
        return $this->responseError(null, 'Not Found', Response::HTTP_NOT_FOUND);
      }

      return $this->responseSuccess($data, 'Ok !');
    } catch (\Exception $e) {
      return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function reportPegawaiResult(Request $request, BbqregRepository $bbqregRepository)
  {
    try {
      $colOrder = [
        1 => 'id',
        2 => 'id',
      ];
      $filterField = [
        'pegawai_id' => 'pegawai_id',
        'mentor_user_id' => 'mentor_user_id',
      ];
      $search  = ($request->input('search')) 
        ? $request->input('search') 
        : '';
      $search  = (is_array($search)) 
        ? $search['value'] 
        : $search;
      $orderField = isset($colOrder[$request->input('order.0.column')])
        ? $colOrder[$request->input('order.0.column')]
        : null;
      $isFiltered = RequestFilterHelper::fieldKey($filterField, $request->all());
      
      
      $whereKeys = [
        'order'  => !empty($orderField) ? [$orderField, $request->input('order.0.dir')] : ['id', 'ASC'],
        'limit'  => $request->input('length'),
        'start'  => $request->input('start'),
        'search' => $search,
        'data'   => $isFiltered,
      ];

      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'code' => 200,
        'data' => $bbqregRepository->countPegawaiSurat($whereKeys)
      ]);
    } catch (\Exception $e) {
      return response()->json(
        [
          'message' => $e->getMessage(),
          'code' => 500,
          'data' => [],
        ],
        Response::HTTP_INTERNAL_SERVER_ERROR
      );
    }
  }

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

}