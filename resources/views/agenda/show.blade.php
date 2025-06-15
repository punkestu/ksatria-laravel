@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8">
        <div class="flex justify-between items-center mb-2">
            <a class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 cursor-pointer"
                href="{{ route('agenda.index') }}">Kembali</a>
            @if (auth()->user() && auth()->user()->isAdmin())
                <aside class="flex items-center gap-2">
                    <a class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600"
                        href="{{ route('agenda.edit', $agenda->id) }}">Edit</a>
                    <form action="{{ route('agenda.destroy', $agenda->id) }}" method="post"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 cursor-pointer">
                            Hapus
                        </button>
                    </form>
                </aside>
            @endif
        </div>
        <div>
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" id="title" name="title" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $agenda->title }}" readonly>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    readonly>{{ $agenda->description }}</textarea>
            </div>
            <div class="mb-4">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                <input type="datetime-local" id="start_time" name="start_time" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $agenda->start_time }}" readonly>
            </div>
            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                <input type="datetime-local" id="end_time" name="end_time" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $agenda->end_time }}" readonly>
            </div>
        </div>
    </main>
@endsection
