<?php

namespace App\Http\Controllers;

use App\Exports\ProgramKerjaItemExport;
use App\Imports\ProgramKerjaItemImport;
use App\Models\ProgramKerja;
use App\Models\ProgramKerjaItem;
use App\Models\User;
use App\Notifications\ProkerCreated;
use App\Notifications\ProkerEdited;
use App\Notifications\ProkerStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Spipu\Html2Pdf\Html2Pdf;

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
        $page = $request->get('page', 1);
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
            $myprogramkerja = $programkerja->items();
        } else {
            $myprogramkerja = $programkerja->items()->where('user_id', Auth::id())
                ->where('cabang_id', Auth::user()->cabang_id);
        }

        $totalPages = ceil($myprogramkerja->count() / 10);
        $myprogramkerja = $myprogramkerja->paginate(10, ['*'], 'page', $page);


        return view('programkerja.index', compact('programkerjas', 'myprogramkerja', 'programkerja', 'programkerjatab', 'page', 'totalPages'));
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
        ProkerStatus::notify($notified, Auth::user(), $programKerjaItem, "diajukan");

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
        if ($me->id != $pengajuanproker->user_id) {
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
        if ($me->cabang_id != $pengajuanproker->cabang_id) {
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
            'resource' => 'nullable|array',
            'resource.*.resource_id' => 'exists:resources,id',
            'resource.*.url' => 'nullable|string',
            'keterangan' => 'required_if:status,approved|string',
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
            'resource.array' => 'Gambar harus berupa array.',
            'resource.*.resource_id.exists' => 'Gambar yang dipilih tidak valid.',
            'resource.*.url.string' => 'URL gambar harus berupa teks.',
            'keterangan.required_if' => 'Keterangan harus diisi jika status program kerja adalah disetujui.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal memperbarui program kerja. Periksa kembali data yang dimasukkan.'
                ])
                ->withErrors($validation)->withInput();
        }

        if ($pengajuanproker->status == 'pending') {
            $pengajuanproker->program_kerja_id = $request->input('program_kerja_id');
            $pengajuanproker->name = $request->input('name');
            $pengajuanproker->description = $request->input('description');
            $pengajuanproker->start_date = $request->input('start_date');
            $pengajuanproker->end_date = $request->input('end_date');

            $pengajuanproker->save();

            $notified = User::where('role', 'admin')->orWhere('id', Auth::id())->get();
            ProkerStatus::notify($notified, Auth::user(), $pengajuanproker, "diubah");
        }
        if ($pengajuanproker->status == 'approved') {
            $pengajuanproker->keterangan = $request->input('keterangan');
            $pengajuanproker->resources()->sync(array_map(function ($resource) {
                return $resource["resource_id"];
            }, $request->input('resource', [])));
            // set current date to tgl_selesai
            $pengajuanproker->tgl_selesai = now();
            $pengajuanproker->status = 'completed';

            // set rating by tgl_selesai compared with start_date and end_date
            $startDate = $pengajuanproker->start_date ? new \DateTime($pengajuanproker->start_date) : new \DateTime();
            $endDate = $pengajuanproker->end_date ? new \DateTime($pengajuanproker->end_date) : new \DateTime();
            $tglSelesai = new \DateTime($pengajuanproker->tgl_selesai);
            $totalDays = $endDate->diff($startDate)->days;
            $daysCompleted = $tglSelesai->diff($startDate)->days;

            // if days completed less than 50% of total days, set rating to 10
            if ($daysCompleted <= ($totalDays * 0.5)) {
                $pengajuanproker->rating = 10;
            } else {
                $halfTotalDays = $totalDays / 2;
                $pengajuanproker->rating = 10 - (5 * (($daysCompleted - $halfTotalDays) / $halfTotalDays));
            }

            $pengajuanproker->save();

            $notified = User::where('role', 'admin')->orWhere('id', Auth::id())->get();
            ProkerStatus::notify($notified, Auth::user(), $pengajuanproker, "diselesaikan");
        }

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
        ProkerStatus::notify($notified, Auth::user(), $pengajuanproker, "dihapus");

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

        $notified = User::where('role', 'admin')->orWhere('id', $pengajuanproker->user_id)->get();
        ProkerStatus::notify($notified, Auth::user(), $pengajuanproker, "disetujui");

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

        $notified = User::where('role', 'admin')->orWhere('id', $pengajuanproker->user_id)->get();
        ProkerStatus::notify($notified, Auth::user(), $pengajuanproker, "ditolak");

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

        $notified = User::where('role', 'admin')->orWhere('id', $pengajuanproker->user_id)->get();
        ProkerStatus::notify($notified, Auth::user(), $pengajuanproker, "diselesaikan");

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

        $notified = User::where('role', 'admin')->orWhere('id', $pengajuanproker->user_id)->get();
        ProkerStatus::notify($notified, Auth::user(), $pengajuanproker, "dibatalkan");

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Program kerja berhasil dibatalkan.'
        ]);
    }

    public function exportpdf(ProgramKerjaItem $pengajuanproker)
    {
        $view = view('programkerja.export', compact('pengajuanproker'));
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($view->render());
        $filename = 'program_kerja_' . $pengajuanproker->id . '_' . now()->format('Ymd_His') . '.pdf';
        $html2pdf->output($filename, 'D');
    }

    public function export(Request $request)
    {
        /**
        * @var User $me
        */
        $me = Auth::user();
        if ($me->isAdmin()) {
            $programkerjas = ProgramKerja::all();
        } else {
            $programkerjas = ProgramKerja::where('cabang_id', $me->cabang_id)->get();
        }
        if ($programkerjas->isEmpty()) {
            return redirect()->route('program-kerja')->with('alert', [
                'type' => 'warning',
                'message' => 'Program kerja belum bisa diakses. Hubungi Administrator.'
            ]);
        }

        return Excel::download(
            new ProgramKerjaItemExport,
            'program_kerja_items_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'import-file' => 'required|file|mimes:xlsx,csv,xls',
        ], [
            'import-file.required' => 'File harus diunggah.',
            'import-file.file' => 'File harus berupa file.',
            'import-file.mimes' => 'File harus berupa file dengan format xlsx, csv, atau xls.',
        ]);

        try {

            $import = new ProgramKerjaItemImport();
            Excel::import($import, $request->file('import-file'));

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Data program kerja berhasil diimpor.'
            ]);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->with('alerts', [
                [
                    'type' => 'error',
                    'message' => 'Gagal mengimpor data program kerja. Periksa kembali format file yang diunggah.'
                ],
                ... array_map(function ($failure) {
                    return [
                        'type' => 'error',
                        'message' => "Baris {$failure->row()}: {$failure->errors()[0]}"
                    ];
                }, $failures)
            ])->withErrors($failures);
        }
    }
}
