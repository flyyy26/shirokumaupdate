<?php

namespace App\Http\Controllers;

use App\Models\StudentStatus;
use Illuminate\Http\Request;

class StudentStatusController extends Controller
{
    public function index()
    {
        $statuses = StudentStatus::orderBy('urutan')->get();
        return view('pengaturan.alur', compact('statuses'));
    }

    public function store(Request $request)
    {
        StudentStatus::create([
            'nama_status' => $request->nama_status,
            'kode_status' => strtolower(str_replace(' ', '_', $request->nama_status)),
            'urutan' => StudentStatus::max('urutan') + 1
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $status = StudentStatus::findOrFail($id);
        $status->update([
            'nama_status' => $request->nama_status
        ]);

        return back();
    }

    public function destroy($id)
    {
        StudentStatus::destroy($id);
        return back();
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            StudentStatus::where('id', $id)->update([
                'urutan' => $index + 1
            ]);
        }

        return response()->json(['success' => true]);
    }
}