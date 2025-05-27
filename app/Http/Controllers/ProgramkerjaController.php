<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;
use App\Models\ProgramKerjaItem;
use App\Models\User;
use App\Notifications\ProkerCreated;
use App\Notifications\ProkerEdited;
use App\Notifications\ProkerStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProgramkerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $programkerjas = ProgramKerja::all();
        if ($programkerjas->isEmpty()) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Program kerja belum bisa diakses. Hubungi Administrator.'
            ]);
        }

        $programkerjatab = $request->get('tab');
        if ($programkerjatab) {
            $programkerja = $programkerjas->where('name', $programkerjatab)->first();
            if (!$programkerja) {
                return redirect()->route('program-kerja')->with('alert', [
                    'type' => 'warning',
                    'message' => 'Program kerja tidak ditemukan.'
                ]);
            }
        } else {
            $programkerja = $programkerjas->first();
        }

        /** @var User $me */
        $me = Auth::user();
        if ($me->isAdmin()) {
            $myprogramkerja = $programkerja->items()->get();
        } else {
            $myprogramkerja = $programkerja->items()->where('user_id', Auth::id())
                ->where('cabang_id', Auth::user()->cabang_id)
                ->get();
        }

        return view('programkerja.index', compact('programkerjas', 'myprogramkerja', 'programkerja'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $programkerjas = ProgramKerja::all();
        if ($programkerjas->isEmpty()) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Program kerja belum bisa diakses. Hubungi Administrator.'
            ]);
        }

        $programkerjatab = $request->get('tab');
        if ($programkerjatab) {
            $programkerja = $programkerjas->where('name', $programkerjatab)->first();
            if (!$programkerja) {
                return redirect()->route('program-kerja')->with('alert', [
                    'type' => 'warning',
                    'message' => 'Program kerja tidak ditemukan.'
                ]);
            }
        } else {
            $programkerja = $programkerjas->first();
        }

        /** @var User $me */
        $me = Auth::user();
        if ($me->isAdmin()) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Hanya user cabang yang dapat membuat program kerja.'
            ]);
        }

        return view('programkerja.create', compact('programkerja', 'programkerjas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = validator($request->all(), [
            'program_kerja_id' => 'required|exists:program_kerjas,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'program_kerja_id.required' => 'Program kerja harus dipilih.',
            'program_kerja_id.exists' => 'Program kerja yang dipilih tidak valid.',
            'name.required' => 'Nama program kerja harus diisi.',
            'name.string' => 'Nama program kerja harus berupa teks.',
            'name.max' => 'Nama program kerja tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Deskripsi program kerja harus berupa teks.',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'end_date.date' => 'Tanggal akhir harus berupa tanggal yang valid.',
            'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal membuat program kerja. Periksa kembali data yang dimasukkan.'
                ])
                ->withErrors($validation)->withInput();
        }

        $programKerjaItem = new ProgramKerjaItem();
        $programKerjaItem->program_kerja_id = $request->input('program_kerja_id');
        $programKerjaItem->name = $request->input('name');
        $programKerjaItem->description = $request->input('description');
        $programKerjaItem->start_date = $request->input('start_date');
        $programKerjaItem->end_date = $request->input('end_date');
        $programKerjaItem->budget = $request->input('budget', 0);
        $programKerjaItem->status = 'pending'; // Default status
        $programKerjaItem->cabang_id = Auth::user()->cabang_id;
        $programKerjaItem->user_id = Auth::id();
        $programKerjaItem->save();

        $notified = User::where('role', 'admin')->orWhere('id', Auth::id())->get();
        ProkerStatus::notify($notified, $programKerjaItem->id, "dibuat");

        $tab = $programKerjaItem->programKerja->name;

        return redirect()->route('pengajuanproker.index', ['tab' => $tab])->with('alert', [
            'type' => 'success',
            'message' => 'Program kerja berhasil dibuat.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramKerjaItem $pengajuanproker)
    {
        $programkerjas = ProgramKerja::all();
        if ($programkerjas->isEmpty()) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Program kerja belum bisa diakses. Hubungi Administrator.'
            ]);
        }

        $programkerja = $programkerjas->find($pengajuanproker->program_kerja_id);
        if (!$programkerja) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Program kerja tidak ditemukan.'
            ]);
        }

        return view('programkerja.show', compact('pengajuanproker', 'programkerja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramKerjaItem $pengajuanproker)
    {
        /** @var User $me */
        $me = Auth::user();
        if ($me->id !== $pengajuanproker->user_id) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Anda tidak memiliki izin untuk mengubah program kerja ini.'
            ]);
        }

        if ($pengajuanproker->status !== 'pending' && $pengajuanproker->status !== 'approved') {
            return redirect()->route('pengajuanproker.index')->with('alert', [
                'type' => 'warning',
                'message' => 'Hanya program kerja dengan status pending atau disetujui yang dapat diubah.'
            ]);
        }

        $programkerjas = ProgramKerja::all();
        if ($programkerjas->isEmpty()) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Program kerja belum bisa diakses. Hubungi Administrator.'
            ]);
        }

        $programkerja = $programkerjas->find($pengajuanproker->program_kerja_id);
        if (!$programkerja) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Program kerja tidak ditemukan.'
            ]);
        }

        return view('programkerja.edit', compact('pengajuanproker', 'programkerjas', 'programkerja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramKerjaItem $pengajuanproker)
    {
        /** @var User $me */
        $me = Auth::user();
        if ($me->id !== $pengajuanproker->user_id) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Anda tidak memiliki izin untuk mengubah program kerja ini.'
            ]);
        }

        if ($pengajuanproker->status !== 'pending' && $pengajuanproker->status !== 'approved') {
            return redirect()->route('pengajuanproker.index')->with('alert', [
                'type' => 'warning',
                'message' => 'Hanya program kerja dengan status pending atau disetujui yang dapat diubah.'
            ]);
        }

        $validation = validator($request->all(), [
            'program_kerja_id' => 'required|exists:program_kerjas,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'required_if:status,approved|numeric|min:0',
            'picture' => 'nullable|array',
            'picture.*.picture_id' => 'exists:pictures,id',
            'picture.*.url' => 'nullable|string',
        ], [
            'program_kerja_id.required' => 'Program kerja harus dipilih.',
            'program_kerja_id.exists' => 'Program kerja yang dipilih tidak valid.',
            'name.required' => 'Nama program kerja harus diisi.',
            'name.string' => 'Nama program kerja harus berupa teks.',
            'name.max' => 'Nama program kerja tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi program kerja harus diisi.',
            'description.string' => 'Deskripsi program kerja harus berupa teks.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'end_date.required' => 'Tanggal akhir harus diisi.',
            'end_date.date' => 'Tanggal akhir harus berupa tanggal yang valid.',
            'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
            'budget.required_if' => 'Anggaran harus diisi jika status program kerja adalah disetujui.',
            'budget.numeric' => 'Anggaran harus berupa angka.',
            'budget.min' => 'Anggaran tidak boleh kurang dari 0.',
            'picture.array' => 'Gambar harus berupa array.',
            'picture.*.picture_id.exists' => 'Gambar yang dipilih tidak valid.',
            'picture.*.url.string' => 'URL gambar harus berupa teks.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal memperbarui program kerja. Periksa kembali data yang dimasukkan.'
                ])
                ->withErrors($validation)->withInput();
        }

        $pengajuanproker->program_kerja_id = $request->input('program_kerja_id');
        $pengajuanproker->name = $request->input('name');
        $pengajuanproker->description = $request->input('description');
        $pengajuanproker->start_date = $request->input('start_date');
        $pengajuanproker->end_date = $request->input('end_date');
        $pengajuanproker->budget = $request->input('budget', 0);
        $pengajuanproker->save();
        $pengajuanproker->pictures()->sync(array_map(function ($picture) {
            return $picture["picture_id"];
        }, $request->input('picture', [])));

        $notified = User::where('role', 'admin')->orWhere('id', Auth::id())->get();
        ProkerStatus::notify($notified, $pengajuanproker->id, "diubah");

        $tab = $pengajuanproker->programKerja->name;

        return redirect()->route('pengajuanproker.index', ['tab' => $tab])->with('alert', [
            'type' => 'success',
            'message' => 'Program kerja berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramKerjaItem $pengajuanproker)
    {
        /** @var User $me */
        $me = Auth::user();
        if ($me->id !== $pengajuanproker->user_id) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Anda tidak memiliki izin untuk menghapus program kerja ini.'
            ]);
        }

        $tab = $pengajuanproker->programKerja->name;
        $pengajuanproker->delete();

        $notified = User::where('role', 'admin')->orWhere('id', Auth::id())->get();
        ProkerStatus::notify($notified, $pengajuanproker->id, "dihapus");

        return redirect()->route('pengajuanproker.index', ['tab' => $tab])->with('alert', [
            'type' => 'success',
            'message' => 'Program kerja berhasil dihapus.'
        ]);
    }

    /**
     * Approve the specified program kerja item.
     */
    public function approve(ProgramKerjaItem $pengajuanproker)
    {
        $pengajuanproker->status = 'approved';
        $pengajuanproker->save();

        $notified = User::where('role', 'admin')->orWhere('id', Auth::id())->get();
        ProkerStatus::notify($notified, $pengajuanproker->id, "di-approve");

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Program kerja berhasil disetujui.'
        ]);
    }

    /**
     * Reject the specified program kerja item.
     */
    public function reject(ProgramKerjaItem $pengajuanproker)
    {
        $pengajuanproker->status = 'rejected';
        $pengajuanproker->save();

        $notified = User::where('role', 'admin')->orWhere('id', Auth::id())->get();
        ProkerStatus::notify($notified, $pengajuanproker->id, "di-reject");

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Program kerja berhasil ditolak.'
        ]);
    }

    /**
     * Mark the specified program kerja item as complete.
     */
    public function complete(ProgramKerjaItem $pengajuanproker)
    {
        $pengajuanproker->status = 'completed';
        $pengajuanproker->save();

        $notified = User::where('role', 'admin')->orWhere('id', Auth::id())->get();
        ProkerStatus::notify($notified, $pengajuanproker->id, "diselesaikan");

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Program kerja berhasil ditandai sebagai selesai.'
        ]);
    }

    /**
     * Mark the specified program kerja item as canceled.
     */
    public function cancel(ProgramKerjaItem $pengajuanproker)
    {
        $pengajuanproker->status = 'canceled';
        $pengajuanproker->save();

        $notified = User::where('role', 'admin')->orWhere('id', Auth::id())->get();
        ProkerStatus::notify($notified, $pengajuanproker->id, "dibatalkan");

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Program kerja berhasil dibatalkan.'
        ]);
    }
}
