<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProgramKerjaItem extends Model
{
    protected $fillable = [
        'program_kerja_id',
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
        'keterangan',
        'tgl_selesai',
        'cabang_id',
        'user_id',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function pictures()
    {
        return $this->belongsToMany(Picture::class, 'program_kerja_item_pictures');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getYearStartToEnd($cabang_id = null)
    {
        $data = Cache::get('program_kerja_item_getYearStartToEnd_' . $cabang_id);
        if ($data) {
            return $data;
        }
        $years = ProgramKerjaItem::selectRaw('YEAR(MIN(start_date)) as start_date, YEAR(MAX(start_date)) as end_date')
            ->when($cabang_id, function ($query) use ($cabang_id) {
                return $query->where('cabang_id', $cabang_id);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'start_date' => $item->start_date,
                    'end_date' => $item->end_date,
                ];
            });
        if ($years->isEmpty()) {
            return null;
        }

        $years = range($years[0]['start_date'], $years[0]['end_date']);
        Cache::put('program_kerja_item_getYearStartToEnd_' . $cabang_id, $years, 60 * 5);
        return $years;
    }

    public static function getByCabang($years, $cabang_id = null)
    {
        $data = Cache::get('program_kerja_item_getByCabang_' . $cabang_id . '_' . implode('_', $years));
        if ($data) {
            return $data;
        }
        $data = ProgramKerjaItem::with(['cabang'])->groupBy(['cabang_id', 'status', 'year'])
            ->selectRaw('cabang_id, status, YEAR(start_date) as year, COUNT(*) as total')
            ->when($cabang_id, function ($query) use ($cabang_id) {
                return $query->where('cabang_id', $cabang_id);
            })
            ->havingRaw('year IN (' . implode(',', $years) . ')')
            ->get()
            ->reduce(function ($carry, $item) use ($years) {
                $cabangName = $item->cabang->name;
                if (!isset($carry[$item->cabang_id])) {
                    $carry[$item->cabang_id] = [
                        'cabang_name' => $cabangName,
                        'status' => [
                            'pending' => array_fill(0, count($years), 0),
                            'approved' => array_fill(0, count($years), 0),
                            'rejected' => array_fill(0, count($years), 0),
                            'completed' => array_fill(0, count($years), 0),
                            'canceled' => array_fill(0, count($years), 0),
                        ]
                    ];
                }
                $status = $item->status;
                $yearIndex = $item->year - $years[0];
                if ($yearIndex >= 0 && $yearIndex < count($years)) {
                    $carry[$item->cabang_id]['status'][$status][$yearIndex] = $item->total;
                }
                return $carry;
            }, []);
        Cache::put('program_kerja_item_getByCabang_' . $cabang_id . '_' . implode('_', $years), $data, 60 * 5);
        return $data;
    }

    public static function getPendingThisYear($year)
    {
        $data = Cache::get('program_kerja_item_getPendingThisYear_' . $year);
        if ($data) {
            return $data;
        }
        $data = ProgramKerjaItem::where('status', 'pending')
            ->whereYear('start_date', $year)
            ->count();
        Cache::put('program_kerja_item_getPendingThisYear_' . $year, $data, 60 * 5);
        return $data;
    }

    public static function getApprovedThisYear($year)
    {
        $data = Cache::get('program_kerja_item_getApprovedThisYear_' . $year);
        if ($data) {
            return $data;
        }
        $data = ProgramKerjaItem::where('status', 'approved')
            ->orWhere('status', 'completed')
            ->orWhere('status', 'canceled')
            ->whereYear('start_date', $year)
            ->count();
        Cache::put('program_kerja_item_getApprovedThisYear_' . $year, $data, 60 * 5);
        return $data;
    }

    public static function getCompletedThisYear($year)
    {
        $data = Cache::get('program_kerja_item_getCompletedThisYear_' . $year);
        if ($data) {
            return $data;
        }
        $data = ProgramKerjaItem::where('status', 'completed')
            ->whereYear('start_date', $year)
            ->count();
        Cache::put('program_kerja_item_getCompletedThisYear_' . $year, $data, 60 * 5);
        return $data;
    }

    public static function getRatingAvg($year)
    {
        $data = Cache::get('program_kerja_item_getRatingAvg_' . $year);
        if ($data) {
            return $data;
        }
        $data = ProgramKerjaItem::with("cabang")->select("cabang_id", DB::raw("AVG(rating) as avg_rating"))->where("status", "completed")->where(DB::raw("YEAR(start_date)"), $year)->groupBy("cabang_id")->orderBy("avg_rating", "desc")->get()->map(function ($item) {
            return [
                'cabang_id' => $item->cabang_id,
                'cabang_name' => $item->cabang->name,
                'avg_rating' => round($item->avg_rating, 2),
            ];
        });
        Cache::put('program_kerja_item_getRatingAvg_' . $year, $data, 60 * 5);
        return $data;
    }
}
