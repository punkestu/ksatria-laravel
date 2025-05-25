<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $fillable = [
        'name',
        'url',
        'user_id',
    ];

    public function programKerjaItems()
    {
        return $this->belongsToMany(ProgramKerjaItem::class, 'program_kerja_item_pictures');
    }
}
