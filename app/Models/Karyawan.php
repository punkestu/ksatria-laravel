<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Karyawan extends Model
{
    protected $fillable = [
        'name',
        'nik',
        'email',
        'phone',
        'gender',
        'cabang_id',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public static function getCountGroupByGender()
    {
        $data = Cache::get('karyawan_getCountGroupByGender');
        if ($data) {
            return $data;
        }
        $data = Karyawan::select("gender", DB::raw("COUNT(*)"))->groupBy("gender")->get()->flatmap(
            function ($row) {
                return [$row["gender"] => $row["COUNT(*)"]];
            }
        );
        Cache::put('karyawan_getCountGroupByGender', $data, 60 * 60); // Cache for 1 hour
        return $data;
    }
}
