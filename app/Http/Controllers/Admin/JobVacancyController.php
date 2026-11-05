<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JobVacancyController extends Controller
{
    public function index()
    {
        $jobs = JobVacancy::orderBy('sort_order', 'asc')->paginate(20);
        return view('admin.job-vacancy.index', compact('jobs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:255',
            'position_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
            'education' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['requirements', 'image']);
        $data['requirements'] = $request->requirements ? array_filter($request->requirements) : [];
        $data['sort_order'] = JobVacancy::max('sort_order') + 1;
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('job-vacancies', 'public');
        }

        $job = JobVacancy::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil ditambahkan',
            'job' => $job
        ]);
    }

    public function update(Request $request, JobVacancy $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:255',
            'position_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
            'education' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['requirements', 'image']);
        $data['requirements'] = $request->requirements ? array_filter($request->requirements) : [];
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            if ($job->image && Storage::disk('public')->exists($job->image)) {
                Storage::disk('public')->delete($job->image);
            }
            $data['image'] = $request->file('image')->store('job-vacancies', 'public');
        }

        $job->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil diperbarui',
            'job' => $job
        ]);
    }

    public function destroy(JobVacancy $job)
    {
        if ($job->image && Storage::disk('public')->exists($job->image)) {
            Storage::disk('public')->delete($job->image);
        }

        $job->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil dihapus'
        ]);
    }

    public function toggleActive(JobVacancy $job)
    {
        $job->update(['is_active' => !$job->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status lowongan berhasil diperbarui',
            'is_active' => $job->is_active
        ]);
    }

    public function toggleFeatured(JobVacancy $job)
    {
        $job->update(['is_featured' => !$job->is_featured]);

        return response()->json([
            'success' => true,
            'message' => 'Status unggulan berhasil diperbarui',
            'is_featured' => $job->is_featured
        ]);
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:job_vacancies,id',
            'orders.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->orders as $order) {
            JobVacancy::where('id', $order['id'])->update(['sort_order' => $order['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan lowongan berhasil diperbarui'
        ]);
    }
}