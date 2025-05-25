<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerjaItemPicture extends Model
{
    protected $fillable = [
        'program_kerja_item_id',
        'picture_id'
    ];

    public function programKerjaItem()
    {
        return $this->belongsTo(ProgramKerjaItem::class);
    }

    public function picture()
    {
        return $this->belongsTo(Picture::class);
    }
}
