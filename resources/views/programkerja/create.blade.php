@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8">
        <a href="{{ route('pengajuanproker.index', ['tab' => $programkerja->name]) }}">Kembali</a>
        <form action="{{ route('pengajuanproker.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="program_kerja_id" class="block text-sm font-medium text-gray-700">Program Kerja</label>
                <select id="program_kerja_id" name="program_kerja_id" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Pilih Program Kerja</option>
                    @foreach ($programkerjas as $proker)
                        <option value="{{ $proker->id }}" {{ (old('program_kerja_id') ?? $programkerja->id) == $proker->id ? 'selected' : '' }}>
                            {{ $proker->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('program_kerja_id'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('program_kerja_id') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('description') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ old('start_date') }}">
                @if ($errors->has('start_date'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('start_date') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ old('end_date') }}">
                @if ($errors->has('end_date'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('end_date') }}</p>
                @endif
            </div>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan
            </button>
        </form>
    </main>
@endsection
