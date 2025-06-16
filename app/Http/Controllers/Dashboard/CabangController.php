<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cabang = Cabang::all();
        return view('dashboard.cabang.index', compact('cabang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.cabang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = validator($request->all(), [
            'name' => 'required|string|max:255',
            'rolemodel' => 'nullable|string|max:255',
            'kaisar' => 'nullable|string|max:255',
            'ksatria' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama cabang harus diisi.',
            'name.string' => 'Nama cabang harus berupa teks.',
            'name.max' => 'Nama cabang tidak boleh lebih dari 255 karakter.',
            'rolemodel.string' => 'Nama role model harus berupa teks.',
            'rolemodel.max' => 'Nama role model tidak boleh lebih dari 255 karakter.',
            'kaisar.string' => 'Nama kaisar harus berupa teks.',
            'kaisar.max' => 'Nama kaisar tidak boleh lebih dari 255 karakter.',
            'ksatria.string' => 'Nama ksatria harus berupa teks.',
            'ksatria.max' => 'Nama ksatria tidak boleh lebih dari 255 karakter.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal menambahkan cabang. Periksa kembali data yang Anda masukkan.',
                ])
                ->withErrors($validation)
                ->withInput();
        }

        Cabang::create([
            'name' => $request->name,
            'ksatria' => $request->ksatria ?? '',
            'kaisar' => $request->kaisar ?? '',
            'rolemodel' => $request->rolemodel ?? '',
        ]);

        return redirect()->route('dashboard.cabang.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Cabang berhasil ditambahkan.',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabang $cabang)
    {
        return view('dashboard.cabang.show', compact('cabang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabang $cabang)
    {
        return view('dashboard.cabang.edit', compact('cabang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cabang $cabang)
    {
        $validation = validator($request->all(), [
            'name' => 'required|string|max:255',
            'rolemodel' => 'nullable|string|max:255',
            'kaisar' => 'nullable|string|max:255',
            'ksatria' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama cabang harus diisi.',
            'name.string' => 'Nama cabang harus berupa teks.',
            'name.max' => 'Nama cabang tidak boleh lebih dari 255 karakter.',
            'rolemodel.string' => 'Nama role model harus berupa teks.',
            'rolemodel.max' => 'Nama role model tidak boleh lebih dari 255 karakter.',
            'kaisar.string' => 'Nama kaisar harus berupa teks.',
            'kaisar.max' => 'Nama kaisar tidak boleh lebih dari 255 karakter.',
            'ksatria.string' => 'Nama ksatria harus berupa teks.',
            'ksatria.max' => 'Nama ksatria tidak boleh lebih dari 255 karakter.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal memperbarui cabang. Periksa kembali data yang Anda masukkan.',
                ])
                ->withErrors($validation)
                ->withInput();
        }

        $cabang->update([
            'name' => $request->name,
            'rolemodel' => $request->rolemodel ?? '',
            'kaisar' => $request->kaisar ?? '',
            'ksatria' => $request->ksatria ?? '',
        ]);

        return redirect()->route('dashboard.cabang.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Cabang berhasil diperbarui.',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabang $cabang)
    {
        $cabang->delete();

        return redirect()->route('dashboard.cabang.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Cabang berhasil dihapus.',
            ]);
    }
}
