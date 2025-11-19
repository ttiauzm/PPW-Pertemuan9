<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportTemplateController extends Controller
{
    public function downloadTemplate()
    {
        $path = storage_path('public/template_import_pelamar.xlsx');
        return response()->download($path, 'template_import_pelamar.xlsx');
    }
}
