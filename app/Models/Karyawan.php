<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
