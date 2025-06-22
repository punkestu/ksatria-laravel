<?php

namespace App\Imports;

use App\Models\ProgramKerja;
use App\Models\ProgramKerjaItem;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

HeadingRowFormatter::default('none');

class ProgramKerjaItemImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ProgramKerjaItem([
            'program_kerja_id' => ProgramKerja::where('name', $row["program_kerja"])->first()->id,
            'name' => $row['nama'],
            'description' => $row['deskripsi'],
            'status' => $row['status'],
            'start_date' => Date::excelToDateTimeObject($row['tanggal_mulai'])->format('Y-m-d'),
            'end_date' => Date::excelToDateTimeObject($row['tanggal_selesai'])->format('Y-m-d'),
            'cabang_id' => Auth::user()->cabang_id,
            'user_id' => Auth::user()->id,
        ]);
    }

    public function headingRow(): int
    {
        return 1; // Assuming the first row contains the headings
    }

    public function rules(): array
    {
        return [
            'program_kerja' => 'required|string|max:255|exists:program_kerjas,name',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:pending,approved,rejected,completed,cancelled',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.program_kerja.required' => 'Program kerja wajib diisi.',
            '*.program_kerja.exists'   => 'Program kerja tidak ditemukan.',
            '*.program_kerja.string'   => 'Program kerja harus berupa teks.',
            '*.program_kerja.max'      => 'Program kerja tidak boleh lebih dari 255 karakter.',
            '*.name.required'          => 'Nama tidak boleh kosong.',
            '*.name.string'            => 'Nama harus berupa teks.',
            '*.name.max'               => 'Nama tidak boleh lebih dari 255 karakter.',
            '*.status.required'        => 'Status wajib dipilih.',
            '*.status.in'              => 'Status harus salah satu dari: pending, approved, rejected, completed, cancelled.',
            '*.start_date.required'    => 'Tanggal mulai harus diisi.',
            '*.end_date.required'      => 'Tanggal selesai harus diisi.',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'program_kerja' => 'Program Kerja',
            'nama' => 'Nama',
            'deskripsi' => 'Deskripsi',
            'status' => 'Status',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
        ];
    }
}
