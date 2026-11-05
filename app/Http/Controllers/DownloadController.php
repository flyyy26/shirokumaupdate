<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index()
    {
        return view('download-formulir');
    }

    public function download($file)
    {
        // Path ke public_html Hostinger
        $path = '/home/u143612213/domains/lpkshirokuma.com/public_html/formulir/' . $file;

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path);
    }
}