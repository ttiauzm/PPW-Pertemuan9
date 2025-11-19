<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Application;

class JobController extends Controller
{
    // ===========================
    // USER: LIST LOWONGAN
    // ===========================
    public function index()
    {
        return view('jobs.manage', [
            'mode' => 'index',
            'jobs' => JobVacancy::latest()->get()
        ]);
    }

    // ===========================
    // USER: DETAIL LOWONGAN
    // ===========================
    public function show($id)
    {
        $job = JobVacancy::findOrFail($id);

        return view('jobs.manage', [
            'mode' => 'show',
            'job' => $job
        ]);
    }

    // ===========================
    // ADMIN: FORM TAMBAH
    // ===========================
    public function create()
    {
        return view('jobs.manage', [
            'mode' => 'create'
        ]);
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'location' => 'required',
            'description' => 'required',
        ]);

        JobVacancy::create($request->all());

        return redirect()->route('jobs.index')
            ->with('success', 'Job created successfully');
    }

    // ===========================
    // ADMIN: FORM EDIT
    // ===========================
    public function edit($id)
    {
        $job = JobVacancy::findOrFail($id);

        return view('jobs.manage', [
            'mode' => 'edit',
            'job' => $job
        ]);
    }

    // Update
    public function update(Request $request, $id)
    {
        $job = JobVacancy::findOrFail($id);

        $job->update($request->all());

        return redirect()->route('jobs.index')
            ->with('success', 'Job updated successfully');
    }

    // Delete
    public function destroy($id)
    {
        JobVacancy::destroy($id);

        return redirect()->route('jobs.index')
            ->with('success', 'Job deleted');
    }

    // ===========================
    // ADMIN: LIST PELAMAR
    // ===========================
    public function applicants($job_id)
    {
        $job = JobVacancy::findOrFail($job_id);
        $applications = Application::where('job_id', $job_id)->with('user')->get();

        return view('jobs.manage', [
            'mode' => 'applicants',
            'job' => $job,
            'applications' => $applications
        ]);
    }
    
}
