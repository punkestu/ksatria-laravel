@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8">
        <a class="bg-red-500 text-white px-4 py-1 rounded mb-4 inline-block"
            href="{{ route('pengajuanproker.index', ['tab' => $programkerja->name]) }}">Kembali</a>

        <div class="flex justify-end gap-2">
            @if (auth()->user()->isAdmin() && $pengajuanproker->status == 'pending')
                <form onsubmit="return otherIntercept('Apakah Anda yakin ingin menyetujui item ini?')"
                    action="{{ route('pengajuanproker.approve', $pengajuanproker->id) }}" method="post"
                    style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button class="bg-green-500 text-white px-4 py-1 rounded mb-4 inline-block cursor-pointer"
                        type="submit">Approve</button>
                </form>
                <form onsubmit="return otherIntercept('Apakah Anda yakin ingin menolak item ini?')"
                    action="{{ route('pengajuanproker.reject', $pengajuanproker->id) }}" method="post"
                    style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button class="bg-red-500 text-white px-4 py-1 rounded mb-4 inline-block cursor-pointer"
                        type="submit">Tolak</button>
                </form>
            @else
                <a class="bg-blue-500 text-white px-4 py-1 rounded mb-4 inline-block cursor-pointer"
                    href="{{ route('pengajuanproker.exportpdf', $pengajuanproker->id) }}">Export</a>
                @if ($pengajuanproker->status == 'pending')
                    <a class="bg-yellow-500 text-white px-4 py-1 rounded mb-4 inline-block cursor-pointer"
                        href="{{ route('pengajuanproker.edit', $pengajuanproker->id) }}">Edit</a>
                    <form onsubmit="deleteIntercept(event)"
                        action="{{ route('pengajuanproker.destroy', $pengajuanproker->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-4 py-1 rounded mb-4 inline-block cursor-pointer"
                            type="submit">Hapus</button>
                    </form>
                @elseif($pengajuanproker->status == 'approved')
                    <a class="bg-yellow-500 text-white px-4 py-1 rounded mb-4 inline-block cursor-pointer"
                        href="{{ route('pengajuanproker.edit', $pengajuanproker->id) }}">Review</a>
                @endif
            @endif
        </div>

        <div class="flex flex-col items-end">
            @php
                $status =
                    [
                        'pending' => 'Diajukan',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ][$pengajuanproker->status] ?? 'Unknown';
            @endphp
            <h2 class="mb-1">
                Status: <span
                    class="px-3 py-1 text-white rounded-full {{ $pengajuanproker->status == 'pending' ? 'bg-yellow-500' : '' }} {{ $pengajuanproker->status == 'approved' ? 'bg-green-500' : '' }} {{ $pengajuanproker->status == 'rejected' ? 'bg-red-500' : '' }} {{ $pengajuanproker->status == 'completed' ? 'bg-blue-500' : '' }} {{ $pengajuanproker->status == 'cancelled' ? 'bg-gray-500' : '' }}">
                    {{ $status }}
                </span>
            </h2>
            <h2 class="mb-4">
                Pada Cabang: {{ $pengajuanproker->cabang->name }}
            </h2>
        </div>

        <div>
            <div class="mb-4">
                <label for="program_kerja_id" class="block text-sm font-medium text-gray-700">Program Kerja</label>
                <select id="program_kerja_id" name="program_kerja_id" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    @readonly(true)>
                    <option>{{ $programkerja->name }}</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="cabang" class="block text-sm font-medium text-gray-700">Cabang</label>
                <input type="text" id="cabang" name="cabang" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $pengajuanproker->cabang->name }}" readonly>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $pengajuanproker->name }}" readonly>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    readonly>{{ $pengajuanproker->description }}</textarea>
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $pengajuanproker->start_date }}" readonly>
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    value="{{ $pengajuanproker->end_date }}" readonly>
            </div>

            @if (
                $pengajuanproker->status === 'approved' ||
                    $pengajuanproker->status === 'rejected' ||
                    $pengajuanproker->status === 'completed')
                @if ($pengajuanproker->resources->isNotEmpty())
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Gambar</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($pengajuanproker->resources as $resource)
                                {{-- <div class="rounded p-2 grow">
                                    <img src="{{ $resource->url }}" alt="{{ $resource->name }}" class="rounded"
                                        onerror="this.url='/images/berkas.svg'">
                                </div> --}}
                                <div data-template="resource-card" class="w-32 aspect-square relative">
                                    <img class="h-full w-full object-cover" src="{{ $resource->url }}"
                                        alt="{{ $resource->alt_text }}" onerror="this.src='/images/berkas.svg'">
                                    <a href="{{ $resource->url }}" title="{{ $resource->alt_text }}"
                                        class="bg-gray-500/30 opacity-0 hover:opacity-100 duration-300 absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778" />
                                        </svg>

                                        <p class="text-xs text-white">
                                            {{ substr($resource->name, 0, 14) }}...
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" required
                        class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        readonly>{{ $pengajuanproker->keterangan }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="tgl_selesai" class="block text-sm font-medium text-gray-700">Diselesaikan
                        Tanggal</label>
                    <input type="date" id="tgl_selesai" name="tgl_selesai" required
                        class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ $pengajuanproker->tgl_selesai }}" readonly>
                </div>
            @endif
        </div>
    </main>
@endsection
