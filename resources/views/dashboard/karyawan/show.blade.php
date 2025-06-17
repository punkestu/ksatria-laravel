@extends('layouts.dashboard')
@section('dashboard-content')
    <a href="{{ route('dashboard.karyawan.index') }}">Kembali</a>
    <div>
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="name" name="name" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ $karyawan->name }}" readonly>
        </div>
        <div class="mb-4">
            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
            <input type="text" id="nik" name="nik" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ $karyawan->nik }}" readonly>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ $karyawan->email }}" readonly>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">No HP (opsional)</label>
            <input type="text" id="phone" name="phone"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ $karyawan->phone }}" readonly>
        </div>
        <div class="mb-4">
            <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
            <div class="mt-1 flex gap-2">
                <label>
                    <input required type="radio" value="Laki-laki" name="gender" id="male"
                        {{ $karyawan->gender == 'Laki-laki' ? 'checked' : 'disabled' }}>
                    Laki-laki
                </label>
                <label>
                    <input required type="radio" value="Perempuan" name="gender" id="female"
                        {{ $karyawan->gender == 'Perempuan' ? 'checked' : 'disabled' }}>
                    Perempuan
                </label>
            </div>
        </div>
        <div class="mb-4">
            <label for="cabang_id" class="block text-sm font-medium text-gray-700">Cabang</label>
            <select id="cabang_id" name="cabang_id"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option selected>{{ $karyawan->cabang->name }}</option>
            </select>
        </div>
    </div>
@endsection
