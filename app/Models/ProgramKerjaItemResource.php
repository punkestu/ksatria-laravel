<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerjaItemResource extends Model
{
    protected $fillable = [
        'program_kerja_item_id',
        'resource_id',
        'type',
        'alt_text',
    ];

    public function programKerjaItem()
    {
        return $this->belongsTo(ProgramKerjaItem::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
