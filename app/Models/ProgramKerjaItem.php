<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
