@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8">
        <a href="{{ route('agenda.index') }}">Kembali</a>
        <form action="{{ route('agenda.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" id="title" name="title" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ old('title') }}">
                @if ($errors->has('title'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('title') }}</p>
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
                <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                <input type="datetime-local" id="start_time" name="start_time" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ old('start_time') }}">
                @if ($errors->has('start_time'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('start_time') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                <input type="datetime-local" id="end_time" name="end_time" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ old('end_time') }}">
                @if ($errors->has('end_time'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('end_time') }}</p>
                @endif
            </div>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan
            </button>
        </form>
    </main>
@endsection
