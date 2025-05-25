@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8">
        <a href="{{ route('pengajuanproker.index', ['tab' => $programkerja->name]) }}">Kembali</a>
        <div>
            <div class="mb-4">
                <label for="program_kerja_id" class="block text-sm font-medium text-gray-700">Program Kerja</label>
                <select id="program_kerja_id" name="program_kerja_id" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    @readonly(true)>
                    <option>{{ $programkerja->name }}</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $pengajuanproker->name }}" readonly>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    readonly>{{ $pengajuanproker->description }}</textarea>
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $pengajuanproker->start_date }}" readonly>
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $pengajuanproker->end_date }}" readonly>
            </div>

            <h2 class="mb-4">
                Status: {{ ucfirst($pengajuanproker->status) }}
            </h2>

            @if (
                $pengajuanproker->status === 'approved' ||
                    $pengajuanproker->status === 'rejected' ||
                    $pengajuanproker->status === 'completed')
                {{-- budget --}}
                <div class="mb-4">
                    <label for="budget" class="block text-sm font-medium text-gray-700">Anggaran</label>
                    <input type="number" id="budget" name="budget" required
                        class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('budget') ?? $pengajuanproker->budget }}" readonly>
                </div>
                @if ($pengajuanproker->pictures->isNotEmpty())
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Gambar</label>
                        <div class="flex flex-wrap justify-center gap-2">
                            @foreach ($pengajuanproker->pictures as $picture)
                                <div class="rounded p-2 grow">
                                    <img src="{{ $picture->url }}" alt="{{ $picture->name }}" class="rounded">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </main>
@endsection
