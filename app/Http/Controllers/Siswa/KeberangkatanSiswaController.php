<?php
// app/Http/Controllers/Siswa/KeberangkatanSiswaController.php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeberangkatanSiswaController extends Controller
{
    /**
     * Display a listing of the resource for siswa.
     */
    public function index()
    {
        // Ambil data siswa yang sedang login
        $siswa = Auth::user()->siswa;
        
        // Load relasi keberangkatan
        $siswa->load('keberangkatan');
        
        // Ambil data keberangkatan siswa
        $keberangkatan = $siswa->keberangkatan;
        
        // Return view untuk siswa
        return view('siswa.keberangkatan.index', compact('siswa', 'keberangkatan'));
    }
}