<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminImportExportController extends Controller
{
    // Export applicants for one job as CSV
    public function exportJobApplicants($job_id)
    {
        $job = JobVacancy::findOrFail($job_id);
        $applications = Application::where('job_id', $job_id)->with('user')->get();

        $filename = 'applications_job_'.$job->id.'.csv';

        $response = new StreamedResponse(function() use ($applications) {
            $handle = fopen('php://output', 'w');
            // header
            fputcsv($handle, ['id','applicant_name','email','status','cv_filename','applied_at']);
            foreach($applications as $a) {
                $cvFilename = basename($a->cv);
                fputcsv($handle, [
                    $a->id,
                    $a->applicant_name,
                    $a->email,
                    $a->status,
                    $cvFilename,
                    $a->created_at,
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');

        return $response;
    }

    // Download import template (CSV)
    public function downloadTemplate()
    {
        $filename = 'template_import_applicants.csv';
        $response = new StreamedResponse(function() {
            $handle = fopen('php://output', 'w');
            // header columns for admin to fill
            fputcsv($handle, ['job_id','applicant_name','email','cv_filename','status']);
            // sample row (optional)
            fputcsv($handle, ['1','Nama Contoh','email@example.com','contoh_cv.pdf','Pending']);
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');

        return $response;
    }

    // Import CSV (admin uploads CSV). NOTE: CV files must already exist in storage/public/cvs with names used in cv_filename
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $path = $request->file('file')->getRealPath();
        $rows = array_map('str_getcsv', file($path));
        $header = array_map('strtolower', $rows[0]);

        for ($i = 1; $i < count($rows); $i++) {
            $row = array_combine($header, $rows[$i]);

            // basic validation
            if (empty($row['job_id']) || empty($row['applicant_name']) || empty($row['email'])) {
                continue;
            }

            // create application (assume cv file exists in storage/app/public/cvs/{$cv_filename})
            Application::create([
                'job_id' => $row['job_id'],
                'user_id' => null,
                'applicant_name' => $row['applicant_name'],
                'email' => $row['email'],
                'cv' => 'cvs/' . ($row['cv_filename'] ?? ''),
                'status' => $row['status'] ?? 'Pending'
            ]);
        }

        return back()->with('success', 'Import completed.');
    }
}
