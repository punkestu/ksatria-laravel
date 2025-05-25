@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8">
        <a href="{{ route('pengajuanproker.index', ['tab' => $programkerja->name]) }}">Kembali</a>
        <form action="{{ route('pengajuanproker.update', $pengajuanproker->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="program_kerja_id" class="block text-sm font-medium text-gray-700">Program Kerja</label>
                <select id="program_kerja_id" name="program_kerja_id" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Pilih Program Kerja</option>
                    @foreach ($programkerjas as $proker)
                        <option value="{{ $proker->id }}"
                            {{ (old('program_kerja_id') ?? $pengajuanproker->program_kerja_id) == $proker->id ? 'selected' : '' }}>
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
                    value="{{ old('name') ?? $pengajuanproker->name }}">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') ?? $pengajuanproker->description }}</textarea>
                @if ($errors->has('description'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('description') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ old('start_date') ?? $pengajuanproker->start_date }}">
                @if ($errors->has('start_date'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('start_date') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ old('end_date') ?? $pengajuanproker->end_date }}">
                @if ($errors->has('end_date'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('end_date') }}</p>
                @endif
            </div>
            @if ($pengajuanproker->status === 'approved')
                <hr class="my-2">
                {{-- budger --}}
                <div class="mb-4">
                    <label for="budget" class="block text-sm font-medium text-gray-700">Anggaran</label>
                    <input type="number" id="budget" name="budget" required
                        class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('budget') ?? $pengajuanproker->budget }}">
                    @if ($errors->has('budget'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('budget') }}</p>
                    @endif
                </div>
                {{-- pictures --}}
                <div class="mb-4">
                    <label for="pictures" class="block text-sm font-medium text-gray-700">Gambar</label>
                    <div class="flex flex-wrap gap-2">
                        @for ($i = 0; $i < 10; $i++)
                            <div class="w-32 aspect-square relative">
                                <img class="h-full w-full object-cover"
                                    src="https://fastly.picsum.photos/id/648/200/300.jpg?hmac=yifVKULNJZhxFK2Oav2kDH8G4unUDKn-OebXR1bWOf4"
                                    alt="test">
                                <input type="hidden" name="picture[]">
                                <button type="button"
                                    class="bg-gray-500/30 opacity-0 hover:opacity-100 duration-300 absolute top-0 left-0 w-full h-full flex justify-center items-center">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                    </svg>
                                </button>
                            </div>
                        @endfor
                        <button type="button"
                            class="bg-gray-500/30 hover:bg-gray-500/100 duration-300 w-32 aspect-square flex justify-center items-center">
                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14m-7 7V5" />
                            </svg>

                        </button>
                    </div>
                    @if ($errors->has('picture'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('picture') }}</p>
                    @endif
                </div>
            @endif
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan
            </button>
        </form>
    </main>
@endsection
@push('script')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const programKerjaSelect = document.getElementById('program_kerja_id');
            programKerjaSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                if (selectedValue) {
                    window.location.href = `{{ route('pengajuanproker.index', ['tab' => '']) }}/${selectedValue}`;
                }
            });
        });
    </script> --}}
@endpush