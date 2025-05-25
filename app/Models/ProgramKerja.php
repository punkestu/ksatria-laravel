<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    protected $fillable = [
        'name'
    ];

    public function items()
    {
        return $this->hasMany(ProgramKerjaItem::class);
    }
}
