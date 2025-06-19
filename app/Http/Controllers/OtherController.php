<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\ProgramKerjaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('statistik', compact('years', 'status', 'thisyear', 'pendingThisYear', 'approvedThisYear', 'completedThisYear', 'karyawanCountPerGender', 'ratingCabang'));
    }
}
