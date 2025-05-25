@extends('layouts.dashboard')
@section('dashboard-content')
    <a href="{{ route('dashboard.cabang.index') }}">Kembali</a>
    <form action="{{ route('dashboard.cabang.store') }}" method="post">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Cabang</label>
            <input type="text" id="name" name="name" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('name') }}">
            @if ($errors->has('name'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Simpan
        </button>
    </form>
@endsection
