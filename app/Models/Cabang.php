<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cabang extends Model
{
    protected $fillable = [
        'name'
    ];

    public function programKerjaItems()
    {
        return $this->hasMany(ProgramKerjaItem::class);
    }
}
