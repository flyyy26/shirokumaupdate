<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLog;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Auth;

class UserLogController extends Controller
{
    public function index()
    {
        $logs = UserLog::where('user_id', Auth::id())
                    ->latest()
                    ->paginate(20);

        logHelper::log(
            'Lihat Log Aktivitas',
            'Melihat daftar log aktivitas'
        );

        return view('logs', compact('logs'));
    }
}
