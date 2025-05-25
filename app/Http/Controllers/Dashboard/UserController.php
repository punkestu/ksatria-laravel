<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('cabang')->get();
        return view('dashboard.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cabangs = \App\Models\Cabang::all();
        return view('dashboard.user.create', compact('cabangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = validator(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'cabang_id' => 'required|exists:cabangs,id',
                'role' => 'required|in:admin,user',
            ],
            [
                'name.required' => 'Nama harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Password harus diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'role.required' => 'Role harus dipilih.',
                'role.in' => 'Role yang dipilih tidak valid.',
                'cabang_id.required' => 'Cabang harus dipilih.',
                'cabang_id.exists' => 'Cabang yang dipilih tidak valid.',
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal menambahkan user. Periksa kembali data yang Anda masukkan.'
                ])
                ->withErrors($validation)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'cabang_id' => $request->cabang_id,
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard.user.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'User berhasil ditambahkan.',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('dashboard.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $cabangs = \App\Models\Cabang::all();
        return view('dashboard.user.edit', compact('user', 'cabangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validation = validator(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'cabang_id' => 'required|exists:cabangs,id',
                'role' => 'required|in:admin,user',
            ],
            [
                'name.required' => 'Nama harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'role.required' => 'Role harus dipilih.',
                'role.in' => 'Role yang dipilih tidak valid.',
                'cabang_id.required' => 'Cabang harus dipilih.',
                'cabang_id.exists' => 'Cabang yang dipilih tidak valid.',
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal memperbarui user. Periksa kembali data yang Anda masukkan.'
                ])
                ->withErrors($validation)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'cabang_id' => $request->cabang_id,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return redirect()->route('dashboard.user.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'User berhasil diperbarui.',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dashboard.user.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'User berhasil dihapus.',
            ]);
    }
}
