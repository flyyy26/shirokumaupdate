<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function index()
    {
        $jobs = JobVacancy::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('job-vacancy', compact('jobs'));
    }
    public function indexJP()
    {
        $jobs = JobVacancy::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('job-vacancy-jp', compact('jobs'));
    }

    public function show(JobVacancy $job)
    {
        // Ambil lowongan terkait (kecuali yang sedang dilihat)
        $relatedJobs = JobVacancy::where('is_active', true)
            ->where('id', '!=', $job->id)
            ->orderBy('sort_order', 'asc')
            ->limit(4)
            ->get();

        return view('job-vacancy-detail', compact('job', 'relatedJobs'));
    }
}