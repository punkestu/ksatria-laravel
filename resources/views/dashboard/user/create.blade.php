@extends('layouts.dashboard')
@section('dashboard-content')
    <a href="{{ route('dashboard.user.index') }}">Kembali</a>
    <form action="{{ route('dashboard.user.store') }}" method="post">
        @csrf
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
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('email') }}">
            @if ($errors->has('email'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
            <div class="w-full border-gray-300 rounded-md shadow-sm flex gap-2 items-center pe-2">
                <input type="password" id="password" name="password"
                    class="p-2 mt-1 block focus:border-indigo-500 rounded-md grow focus:ring-indigo-500 sm:text-sm">
                <label for="show-password">
                    <input class="peer hidden" type="checkbox" id="show-password">
                    <svg class="w-6 h-6 text-gray-800 peer-checked:hidden" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2"
                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg class="w-6 h-6 text-gray-800 hidden peer-checked:flex" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </label>
            </div>
            @if ($errors->has('password'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
            <div class="w-full border-gray-300 rounded-md shadow-sm flex gap-2 items-center pe-2">
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="p-2 mt-1 block focus:border-indigo-500 rounded-md grow focus:ring-indigo-500 sm:text-sm">
                <label for="show-password_confirmation">
                    <input class="peer hidden" type="checkbox" id="show-password_confirmation">
                    <svg class="w-6 h-6 text-gray-800 peer-checked:hidden" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2"
                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg class="w-6 h-6 text-gray-800 hidden peer-checked:flex" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </label>
            </div>
            @if ($errors->has('password_confirmation'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="cabang_id" class="block text-sm font-medium text-gray-700">Cabang</label>
            <select id="cabang_id" name="cabang_id"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Pilih Cabang</option>
                @foreach ($cabangs as $cabang)
                    <option value="{{ $cabang->id }}" {{ old('cabang_id') == $cabang->id ? 'selected' : '' }}>
                        {{ $cabang->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('cabang_id'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('cabang_id') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
            <select id="role" name="role"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @if ($errors->has('role'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('role') }}</p>
            @endif
        </div>
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Simpan
        </button>
    </form>
@endsection
@push('scripts')
    <script>
        function onshowpassword() {
            $('#show-password').change(function() {
                if ($(this).is(':checked')) {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
            $('#show-password_confirmation').change(function() {
                if ($(this).is(':checked')) {
                    $('#password_confirmation').attr('type', 'text');
                } else {
                    $('#password_confirmation').attr('type', 'password');
                }
            });
        }
        onloads.push(onshowpassword);
    </script>
@endpush
