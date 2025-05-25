@extends('layouts.dashboard')
@section('dashboard-content')
    <a href="{{ route('dashboard.user.index') }}">Kembali</a>
    <div>
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="name" name="name" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ $user->name }}" readonly>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ $user->email }}" readonly>
        </div>
        <div class="mb-4">
            <label for="cabang_id" class="block text-sm font-medium text-gray-700">Cabang</label>
            <select id="cabang_id" name="cabang_id"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
                <option selected>{{ $user->cabang->name }}</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
            <select id="role" name="role"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
                <option selected>
                    {{ $user->role == 'admin' ? 'Admin' : 'User' }}
                </option>
            </select>
        </div>
    </div>
@endsection
