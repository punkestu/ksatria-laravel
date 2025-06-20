@extends('layouts.dashboard')
@section('dashboard-content')
    <a href="{{ route('dashboard.cabang.index') }}">Kembali</a>
    <form action="{{ route('dashboard.cabang.update', $cabang->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Cabang</label>
            <input type="text" id="name" name="name" required
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('name') ?? $cabang->name }}">
            @if ($errors->has('name'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="rolemodel" class="block text-sm font-medium text-gray-700">Role Model</label>
            <input type="text" id="rolemodel" name="rolemodel"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('rolemodel') ?? $cabang->rolemodel }}">
            @if ($errors->has('rolemodel'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('rolemodel') }}</p>
            @endif
        </div>
        <div class="mb-4">
            <label for="kaisar" class="block text-sm font-medium text-gray-700">Kaisar</label>
            <input type="text" id="kaisar" name="kaisar"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('kaisar') ?? $cabang->kaisar }}">
            @if ($errors->has('kaisar'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('kaisar') }}</p>
            @endif
        </div>
        <div class="mb-4">
            @php
                $ksatrias = explode('|', $cabang->ksatria);
            @endphp
            <label for="ksatria" class="block text-sm font-medium text-gray-700">Ksatria</label>
            <input type="text" id="ksatria" name="ksatria[]"
                class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                value="{{ old('ksatria') ? old('ksatria')[0] : $ksatrias[0] }}">
            <div id="ksatria-input-container">
                @foreach ($ksatrias as $index => $ksatria)
                    @if ($index > 0)
                        <div class="flex gap-2 mt-2">
                            <input type="text" name="ksatria[]"
                                class="p-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('ksatria.' . $index) ?? $ksatria }}">
                            <button class="bg-red-500 text-white px-2 py-1 rounded-md mt-1" type="button"
                                onclick="this.parentElement.remove()">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endif
                @endforeach
            </div>
            <button class="mt-1 bg-accent-4 text-white px-2 py-1 rounded-md flex gap-1" type="button"
                onclick="addKsatriaInput()">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Ksatria
            </button>
            @error('ksatria.*')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Simpan
        </button>
    </form>
@endsection
@push('scripts')
    <script>
        function addKsatriaInput() {
            $("#ksatria-input-container").append(`
                <div class="flex gap-2 mt-2">
                    <input type="text" name="ksatria[]"
                        class="p-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <button class="bg-red-500 text-white px-2 py-1 rounded-md mt-1" type="button"
                        onclick="this.parentElement.remove()">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `);
        }
    </script>
@endpush
