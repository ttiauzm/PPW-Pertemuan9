<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    // Store application (user uploads CV)
    public function store(Request $request, $id)
    {
        $job = JobVacancy::findOrFail($id);

        $request->validate([
            'applicant_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        // simpan CV
        $cvPath = $request->file('cv')->store('cvs', 'public');

        Application::create([
            'user_id' => auth()->id() ?? null,
            'job_id' => $job->id,
            'applicant_name' => $request->input('applicant_name'),
            'email' => $request->input('email'),
            'cv' => $cvPath,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Application submitted successfully.');
    }

    // Admin: accept
    public function accept($id)
    {
        $app = Application::findOrFail($id);
        $app->update(['status' => 'Accepted']);
        return back()->with('success', 'Applicant accepted.');
    }

    // Admin: reject
    public function reject($id)
    {
        $app = Application::findOrFail($id);
        $app->update(['status' => 'Rejected']);
        return back()->with('success', 'Applicant rejected.');
    }

    // Download CV (admin or the applicant who uploaded)
    public function downloadCv($id)
    {
        $app = Application::findOrFail($id);

        if (!auth()->check()) {
            abort(403);
        }

        // allow admin or owner by user_id or matching email (if guest)
        if (!auth()->user()->is_admin && auth()->id() !== $app->user_id) {
            abort(403);
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($app->cv)) {
            abort(404, 'File not found.');
        }

        $filename = $app->applicant_name . '_CV.' . pathinfo($app->cv, PATHINFO_EXTENSION);
        return $disk->download($app->cv, $filename);
    }
}
