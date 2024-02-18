<?php

namespace App\Traits;

use App\Exports\GenericViewExport;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

trait ExcelTrait
{
    public function generateExcelFromView($contract, $file, $view, $path): JsonResponse
    {
        ini_set('memory_limit', config('dispatcher.memory_limit'));
        $data = $contract->search(request()?->all(), explode( ',', request('embed')), true, false, request('exportLimit') ?? config('dispatcher.max_report_limit'));
        $file = now()->format('Y-m-d-H-i-s')."-".$file;
        Excel::store(new GenericViewExport($data, $view), "downloaded/excel/reports/$file");
        return response()->json([
            'url' => "$path/$file"
        ]);
    }
}
