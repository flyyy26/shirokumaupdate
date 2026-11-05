<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\InterviewLog;
use App\Models\Siswa;

class SiswaInterviewController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $logs = $siswa->interviewLogs()
                ->with(['company','job'])
                ->latest()
                ->get();

        return view('siswa.interview', compact('siswa', 'logs'));
    }
}