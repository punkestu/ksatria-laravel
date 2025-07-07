<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Karyawan;
use App\Models\ProgramKerja;
use App\Models\ProgramKerjaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OtherController extends Controller
{
    public function statisticPage()
    {
        /**
            @var User $me
         */
        $me = Auth::user();
        $cabang_id = null;
        if (!$me->isAdmin()) {
            $cabang_id = $me->cabang_id;
        }
        $years = ProgramKerjaItem::getYearStartToEnd($cabang_id);
        if (!$years) {
            return redirect()->route('home')->with('alert', [
                'type' => 'warning',
                'message' => 'Tidak ada data program kerja yang tersedia untuk statistik.'
            ]);
        }
        $status = ProgramKerjaItem::getByCabang($years, $cabang_id);
        $thisyear = date('Y');

        $pendingThisYear = ProgramKerjaItem::getPendingThisYear($thisyear);
        $approvedThisYear = ProgramKerjaItem::getApprovedThisYear($thisyear);
        $completedThisYear = ProgramKerjaItem::getCompletedThisYear($thisyear);

        $karyawanCountPerGender = Karyawan::getCountGroupByGender();
        $ratingCabang = ProgramKerjaItem::getRatingAvg($thisyear);

        $cabangs = Cache::remember('cabang_list', 60, function () {
            return Cabang::all();
        });

        return view('statistik', compact('years', 'status', 'thisyear', 'pendingThisYear', 'approvedThisYear', 'completedThisYear', 'karyawanCountPerGender', 'ratingCabang', 'cabangs'));
    }

    public function distprokerApi(Request $request)
    {
        $cabang_id = $request->input('cabang_id');

        if (!$cabang_id) {
            return response()->json(['error' => 'Cabang ID is required'], 400);
        }

        $thisyear = date('Y');
        $prokeritembyproker = Cache::remember("prokercount_{$cabang_id}_{$thisyear}", 60, function () use ($cabang_id, $thisyear) {
            return ProgramKerjaItem::with(['programKerja'])
                ->where('cabang_id', $cabang_id)
                ->whereYear('created_at', $thisyear)
                ->get()
                ->groupBy('programKerja.name');
        });
        if (!$prokeritembyproker) {
            return response()->json(['error' => 'No data found for the given Cabang ID'], 404);
        }

        $data = $prokeritembyproker->map(function ($items, $programName) {
            return $items->count();
        });
        $cabang = Cabang::find($cabang_id);
        return response()->json([
            'data' => $data,
            'cabang' => $cabang ? $cabang->name : 'Unknown Cabang',
        ]);
    }
}
