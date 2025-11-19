<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicantsExport implements FromCollection, WithHeadings
{
    protected $jobId;

    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }

    public function collection()
    {
        return Application::where('job_id', $this->jobId)
            ->with('user:id,name,email') // ambil field yang dibutuhkan saja
            ->get()
            ->map(function ($a) {
                return [
                    'Nama' => $a->user->name ?? '-',   // aman jika user null
                    'Email' => $a->user->email ?? '-',
                    'Status' => $a->status,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Status'];
    }
}
