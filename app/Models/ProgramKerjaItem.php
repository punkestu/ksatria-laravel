<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'budget',
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

    public static function getYearStartToEnd()
    {
        $years = ProgramKerjaItem::selectRaw('YEAR(MIN(start_date)) as start_date, YEAR(MAX(start_date)) as end_date')
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
        return $years;
    }

    public static function getByCabang($years)
    {
        return ProgramKerjaItem::with(['cabang'])->groupBy(['cabang_id', 'status', 'year'])
            ->selectRaw('cabang_id, status, YEAR(start_date) as year, COUNT(*) as total')
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
    }

    public static function getMostApproved($year = null)
    {
        return ProgramKerjaItem::with(['cabang'])
            ->selectRaw('cabang_id, COUNT(*) as total')
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('start_date', $year);
            })
            ->whereIn('status', ['approved', 'completed', 'canceled'])
            ->groupBy('cabang_id')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'cabang_name' => $item->cabang->name,
                    'total' => $item->total,
                ];
            })
            ->first();
    }

    public static function getLongestDuration($year)
    {
        return ProgramKerjaItem::selectRaw('id, name, cabang_id, MAX(DATEDIFF(end_date, start_date)) as max_duration')
            ->whereYear('start_date', $year)
            ->whereIn('status', ['approved', 'completed', 'canceled'])
            ->groupBy(['id', 'cabang_id', 'name'])
            ->orderBy('max_duration', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'cabang_name' => Cabang::find($item->cabang_id)->name,
                    'max_duration' => $item->max_duration,
                ];
            })
            ->first();
    }

    public static function getMostExpensive($year)
    {
        return ProgramKerjaItem::selectRaw('id, name, cabang_id, MAX(budget) as max_budget')
            ->whereYear('start_date', $year)
            ->whereIn('status', ['approved', 'completed', 'canceled'])
            ->groupBy(['id', 'cabang_id', 'name'])
            ->orderBy('max_budget', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'cabang_name' => Cabang::find($item->cabang_id)->name,
                    'max_budget' => $item->max_budget,
                ];
            })
            ->first();
    }

    public static function getCheapest($year)
    {
        return ProgramKerjaItem::selectRaw('id, name, cabang_id, MIN(budget) as min_budget')
            ->whereYear('start_date', $year)
            ->where('budget', '>', 0)
            ->whereIn('status', ['approved', 'completed', 'canceled'])
            ->groupBy(['id', 'cabang_id', 'name'])
            ->orderBy('min_budget', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'cabang_name' => Cabang::find($item->cabang_id)->name,
                    'min_budget' => $item->min_budget,
                ];
            })
            ->first();
    }
}
