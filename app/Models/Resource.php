<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'name',
        'url',
        'user_id',
        'type',
        'description',
        'alt_text',
    ];

    public function programKerjaItems()
    {
        return $this->belongsToMany(ProgramKerjaItem::class, 'program_kerja_item_resources');
    }
}
