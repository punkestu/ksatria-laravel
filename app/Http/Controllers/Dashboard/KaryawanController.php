<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = Karyawan::with('cabang')->get();
        return view('dashboard.karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cabang_id = $request->get('cabang', null);
        $cabangs = \App\Models\Cabang::all();
        return view('dashboard.karyawan.create', compact('cabang_id', 'cabangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = validator(
            $request->all(),
            [
                "name" => "required|string|max:255",
                "nik" => "required|string|max:255|unique:karyawans,nik",
                "email" => "nullable|email|max:255|unique:karyawans,email",
                "phone" => "nullable|string|max:32",
                "gender" => "required|in:Laki-laki,Perempuan",
                "cabang_id" => "required|exists:cabangs,id",
            ],
            [
                "name.required" => "Nama karyawan harus diisi.",
                "nik.required" => "NIK karyawan harus diisi.",
                "nik.unique" => "NIK karyawan sudah terdaftar.",
                "email.required" => "Email karyawan harus diisi.",
                "email.unique" => "Email karyawan sudah terdaftar.",
                "gender.required" => "Jenis kelamin karyawan harus dipilih.",
                "gender.in" => "Jenis kelamin karyawan tidak valid.",
                "cabang_id.required" => "Cabang karyawan harus dipilih.",
                "cabang_id.exists" => "Cabang yang dipilih tidak valid.",
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()
                ->with("alert", [
                    "type" => "error",
                    "message" => "Gagal menambahkan karyawan. Periksa kembali data yang Anda masukkan."
                ])
                ->withErrors($validation)
                ->withInput();
        }

        Karyawan::create([
            "name" => $request->name,
            "nik" => $request->nik,
            "email" => $request->email,
            "phone" => $request->phone,
            "gender" => $request->gender,
            "cabang_id" => $request->cabang_id,
        ]);

        return redirect()->route('dashboard.karyawan.index')
            ->with("alert", [
                "type" => "success",
                "message" => "Karyawan berhasil ditambahkan."
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        return view('dashboard.karyawan.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $cabangs = \App\Models\Cabang::all();
        return view('dashboard.karyawan.edit', compact('karyawan', 'cabangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validation = validator(
            $request->all(),
            [
                "name" => "required|string|max:255",
                "nik" => "required|string|max:255|unique:karyawans,nik," . $karyawan->id,
                "email" => "nullable|email|max:255|unique:karyawans,email," . $karyawan->id,
                "phone" => "nullable|string:32",
                "gender" => "required|in:Laki-laki,Perempuan",
                "cabang_id" => "required|exists:cabangs,id",
            ],
            [
                "name.required" => "Nama karyawan harus diisi.",
                "nik.required" => "NIK karyawan harus diisi.",
                "nik.unique" => "NIK karyawan sudah terdaftar.",
                "email.required" => "Email karyawan harus diisi.",
                "email.unique" => "Email karyawan sudah terdaftar.",
                "gender.required" => "Jenis kelamin karyawan harus dipilih.",
                "gender.in" => "Jenis kelamin karyawan tidak valid.",
                "cabang_id.required" => "Cabang karyawan harus dipilih.",
                "cabang_id.exists" => "Cabang yang dipilih tidak valid.",
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()
                ->with("alert", [
                    "type" => "error",
                    "message" => "Gagal mengubah karyawan. Periksa kembali data yang Anda masukkan."
                ])
                ->withErrors($validation)
                ->withInput();
        }

        $karyawan->update($request->all());

        return redirect()->route('dashboard.karyawan.index')
            ->with("alert", [
                "type" => "success",
                "message" => "Karyawan berhasil diubah."
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('dashboard.karyawan.index')
            ->with("alert", [
                "type" => "success",
                "message" => "Karyawan berhasil dihapus."
            ]);
    }
}
