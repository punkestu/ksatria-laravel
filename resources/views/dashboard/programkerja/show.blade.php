@extends('layouts.dashboard')
@section('dashboard-content')
    <a class="bg-red-500 text-white px-4 py-1 rounded mb-4 inline-block"
        href="{{ route('dashboard.programkerja.index') }}">Kembali</a>
    <div>
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Program Kerja</label>
            <input type="text" id="name" name="name" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ $programkerja->name }}" readonly>
        </div>
    </div>
@endsection
