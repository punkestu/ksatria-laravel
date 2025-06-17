@extends('layouts.dashboard')
@section('dashboard-content')
    <a href="{{ route('dashboard.karyawan.index') }}">Kembali</a>
    <form action="{{ route('dashboard.karyawan.update', $karyawan->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="name" name="name" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('name') ?? $karyawan->name }}">
            @if ($errors->has('name'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
            <input type="text" id="nik" name="nik" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('nik') ?? $karyawan->nik }}">
            @if ($errors->has('nik'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('nik') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('email') ?? $karyawan->email }}">
            @if ($errors->has('email'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">No HP (opsional)</label>
            <input type="text" id="phone" name="phone"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('phone') ?? $karyawan->phone }}">
            @if ($errors->has('phone'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('phone') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
            <div class="mt-1 flex gap-2">
                <label>
                    <input required type="radio" value="Laki-laki" name="gender" id="male"
                        {{ $karyawan->gender == 'Laki-laki' ? 'checked' : '' }}>
                    Laki-laki
                </label>
                <label>
                    <input required type="radio" value="Perempuan" name="gender" id="female"
                        {{ $karyawan->gender == 'Perempuan' ? 'checked' : '' }}>
                    Perempuan
                </label>
            </div>
            @if ($errors->has('gender'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('gender') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="cabang_id" class="block text-sm font-medium text-gray-700">Cabang</label>
            <select id="cabang_id" name="cabang_id"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Pilih Cabang</option>
                @foreach ($cabangs as $cabang)
                    <option value="{{ $cabang->id }}"
                        {{ old('cabang_id') == $cabang->id || $karyawan->cabang_id == $cabang->id ? 'selected' : '' }}>
                        {{ $cabang->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('cabang_id'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('cabang_id') }}</p>
            @endif
        </div>
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Simpan
        </button>
    </form>
@endsection
