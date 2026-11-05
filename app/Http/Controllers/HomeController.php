<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 2 lowongan terbaru yang aktif
        $latestJobs = JobVacancy::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->limit(2)
            ->get();

        return view('home', compact('latestJobs'));
    }
    public function indexJP()
    {
        // Ambil 2 lowongan terbaru yang aktif
        $latestJobs = JobVacancy::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->limit(2)
            ->get();

        return view('home-jp', compact('latestJobs'));
    }
}