<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class ProgramkerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programKerjas = ProgramKerja::all();
        return view('dashboard.programkerja.index', compact('programKerjas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.programkerja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = validator(
            $request->all(),
            [
                'name' => 'required|string|max:255|unique:program_kerjas,name',
            ],
            [
                'name.required' => 'Nama Program Kerja harus diisi.',
                'name.string' => 'Nama Program Kerja harus berupa teks.',
                'name.max' => 'Nama Program Kerja tidak boleh lebih dari 255 karakter.',
                'name.unique' => 'Nama Program Kerja sudah ada. Silakan gunakan nama yang berbeda.',
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal menambahkan Program Kerja. Periksa kembali input Anda.'
                ])
                ->withErrors($validation)->withInput();
        }

        ProgramKerja::create([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.programkerja.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Program Kerja berhasil ditambahkan.'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramKerja $programkerja)
    {
        return view('dashboard.programkerja.show', compact('programkerja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramKerja $programkerja)
    {
        return view('dashboard.programkerja.edit', compact('programkerja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramKerja $programkerja)
    {
        $validation = validator(
            $request->all(),
            [
                'name' => 'required|string|max:255|unique:program_kerjas,name,' . $programkerja->id,
            ],
            [
                'name.required' => 'Nama Program Kerja harus diisi.',
                'name.string' => 'Nama Program Kerja harus berupa teks.',
                'name.max' => 'Nama Program Kerja tidak boleh lebih dari 255 karakter.',
                'name.unique' => 'Nama Program Kerja sudah ada. Silakan gunakan nama yang berbeda.',
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal memperbarui Program Kerja. Periksa kembali input Anda.'
                ])
                ->withErrors($validation)->withInput();
        }

        $programkerja->update([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.programkerja.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Program Kerja berhasil diperbarui.'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramKerja $programkerja)
    {
        $programkerja->delete();

        return redirect()->route('dashboard.programkerja.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Program Kerja berhasil dihapus.'
            ]);
    }
}
