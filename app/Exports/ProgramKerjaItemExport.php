<?php

namespace App\Exports;

use App\Models\ProgramKerjaItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProgramKerjaItemExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ProgramKerjaItem::with(['programKerja'])->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'program_kerja' => $item->programKerja->name,
                'nama' => $item->name,
                'deskripsi' => $item->description,
                'tanggal_mulai' => $item->start_date,
                'tanggal_selesai' => $item->end_date,
                'status' => $item->status,
                'keterangan' => $item->keterangan,
                'tanggal_diselesaikan' => $item->tgl_selesai,
                'rating' => $item->rating,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Program Kerja',
            'Nama',
            'Deskripsi',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
            'Keterangan',
            'Tanggal Diselesaikan',
            'Rating',
        ];
    }
}
