<?php

namespace App\Http\Controllers;

use App\Exports\ApplicantsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export($job_id)
    {
        return Excel::download(new ApplicantsExport($job_id), 'pelamar_job_'.$job_id.'.xlsx');
    }
}
