<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('agenda.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = validator(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after_or_equal:start_time',
            ],
            [
                'title.required' => 'Judul agenda harus diisi.',
                'title.string' => 'Judul agenda harus berupa teks.',
                'title.max' => 'Judul agenda tidak boleh lebih dari 255 karakter.',
                'start_time.required' => 'Waktu mulai agenda harus diisi.',
                'start_time.date' => 'Waktu mulai harus dalam format waktu.',
                'end_time.required' => 'Waktu selesai agenda harus diisi.',
                'end_time.date' => 'Waktu selesai harus dalam format waktu.',
                'end_time.after_or_equal' => 'Waktu selesai harus setelah atau sama dengan waktu mulai.',
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal menambahkan Agenda. Periksa kembali input Anda.'
                ])
                ->withErrors($validation)
                ->withInput();
        }

        Agenda::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('agenda.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Agenda berhasil ditambahkan.'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agenda $agenda) {
        return view('agenda.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        return view('agenda.edit', compact('agenda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        $validation = validator(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after_or_equal:start_time',
            ],
            [
                'title.required' => 'Judul agenda harus diisi.',
                'title.string' => 'Judul agenda harus berupa teks.',
                'title.max' => 'Judul agenda tidak boleh lebih dari 255 karakter.',
                'start_time.required' => 'Waktu mulai agenda harus diisi.',
                'start_time.date' => 'Waktu mulai harus dalam format waktu.',
                'end_time.required' => 'Waktu selesai agenda harus diisi.',
                'end_time.date' => 'Waktu selesai harus dalam format waktu.',
                'end_time.after_or_equal' => 'Waktu selesai harus setelah atau sama dengan waktu mulai.',
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'error',
                    'message' => 'Gagal memperbarui Agenda. Periksa kembali input Anda.'
                ])
                ->withErrors($validation)
                ->withInput();
        }

        $agenda->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('agenda.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Agenda berhasil diperbarui.'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Agenda berhasil dihapus.'
            ]);
    }

    public function getAgendaApi(Request $request)
    {
        $validation = validator(
            $request->all(),
            [
                'start_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            ],
            [
                'start_date.required' => 'Tanggal mulai harus diisi.',
                'start_date.date_format' => 'Format tanggal mulai tidak valid.',
                'end_date.required' => 'Tanggal selesai harus diisi.',
                'end_date.date_format' => 'Format tanggal selesai tidak valid.',
                'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            ]
        );

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $agendas = Agenda::whereBetween('start_time', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ])->get();

        return response()->json([
            'message' => 'Agenda retrieved successfully',
            'data' => $agendas,
        ], 200);
    }
}
