<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function provinces()
    {
        return DB::table('provinces')
            ->orderBy('name')
            ->get();
    }

    public function regencies($provinceId)
    {
        return DB::table('regencies')
            ->where('province_id', $provinceId)
            ->orderBy('name')
            ->get();
    }

    public function districts($regencyId)
    {
        return DB::table('districts')
            ->where('regency_id', $regencyId)
            ->orderBy('name')
            ->get();
    }

    public function villages($districtId)
    {
        return DB::table('villages')
            ->where('district_id', $districtId)
            ->orderBy('name')
            ->get();
    }
}