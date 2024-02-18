<?php

namespace App\Http\Controllers\Api\V1;


use App\Traits\ExcelTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ActivityLogContract;

class ReportExportController extends Controller
{
    use ExcelTrait;

    private ActivityLogContract $logContract;
    private String $path = '/storage/downloaded/excel/reports';

    public function __construct()
    {
        $this->logContract = app(ActivityLogContract::class);
    }

    public function logsExport(): JsonResponse
    {
        return $this->generateExcelFromView(
            $this->logContract,
            "logs-report.xlsx",
            "logs-report",
            $this->path
        );
    }

}
