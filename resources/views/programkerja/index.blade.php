@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8 bg-gray-50">
        <section class="flex justify-between">
            <h2 class="font-semibold text-2xl">Program Kerja</h2>
            @if (!auth()->user()->isAdmin())
                <a class="bg-accent-4 text-white px-4 py-1 rounded hover:bg-accent-5"
                    href="{{ route('pengajuanproker.create', ['tab' => $programkerja->name]) }}">Tambah</a>
            @endif
        </section>
        <section id="head" class="pt-2 overflow-x-scroll scrollbar-hidden">
            <nav id="tabs" class="flex gap-4">
                @foreach ($programkerjas as $item)
                    <a class="{{ $programkerja->name == $item->name ? 'bg-accent-4 text-white' : '' }} px-2 py-1"
                        href="{{ route('pengajuanproker.index', ['tab' => $item->name]) }}">{{ $item->name }}</a>
                @endforeach
            </nav>
        </section>
        <section class="grid grid-cols-6 gap-4 shadow bg-white p-4">
            <aside class="order-2 lg:order-1 col-span-6 lg:col-span-1">
                @php
                    $image =
                        [
                            'KSATRIA BAIK' => '/images/program-kerja/KSATRIA BAIK.png',
                            'KSATRIA BISA' => '/images/program-kerja/KSATRIA BISA.png',
                            'KSATRIA PINTAR' => '/images/program-kerja/KSATRIA PINTAR.png',
                            'KSATRIA RELIGI' => '/images/program-kerja/KSATRIA RELIGI.png',
                            'KSATRIA RESIK' => '/images/program-kerja/KSATRIA RESIK.png',
                            'KSATRIA SALAM' => '/images/program-kerja/KSATRIA SALAM.png',
                            'KSATRIA SEHAT' => '/images/program-kerja/KSATRIA SEHAT.png',
                            'KSATRIA S.H.A.R.E' => '/images/program-kerja/KSATRIA SHARE.png',
                        ][$programkerja->name] ?? '/images/program-kerja/8 KSATRIA.png';
                @endphp
                <img class="w-full mt-2 scale-100 hover:scale-125 duration-500" src="{{ $image }}"
                    alt="{{ $programkerja->name }}">
            </aside>
            <aside class="order-1 lg:order-2 col-span-6 lg:col-span-5">
                <div class="overflow-x-auto">
                    <table class="w-[500vw] md:w-[175vw] xl:w-[120vw] 2xl:w-[80vw]">
                        <thead>
                            <tr class="border-b">
                                <th class="px-2 py-1 w-3">No.</th>
                                <th class="px-2 py-1 w-3">ID</th>
                                <th class="text-left px-2 py-1 w-1/6">Nama Program Kerja</th>
                                <th class="text-left px-2 py-1 w-1/5">Deskripsi</th>
                                <th class="text-left px-2 py-1">Status</th>
                                <th class="text-left px-2 py-1">Dari-Sampai</th>
                                <th class="text-left px-2 py-1">Tanggal Selesai</th>
                                @if (auth()->user()->isAdmin())
                                    <th class="text-left px-2 py-1">Cabang</th>
                                    <th class="text-left px-2 py-1">Dibuat Oleh</th>
                                @endif
                                <th class="px-2 py-1 w-1/6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($myprogramkerja as $item)
                                <tr
                                    class="border-b border-black/10 {{ $loop->index % 2 == 0 ? 'bg-slate-50' : '' }} hover:bg-slate-200">
                                    <td class="px-2 py-1">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-1">{{ $item->id }}</td>
                                    <td class="px-2 py-1">{{ $item->name }}</td>
                                    <td class="px-2 py-1">
                                        {{ Str::limit($item->description, 50) }}
                                    </td>
                                    @php
                                        $status =
                                            [
                                                'pending' => 'Diajukan',
                                                'approved' => 'Disetujui',
                                                'rejected' => 'Ditolak',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan',
                                            ][$item->status] ?? 'Unknown';
                                    @endphp
                                    <td class="px-2 py-1">
                                        <span
                                            class="px-3 py-1 text-white rounded-full {{ $item->status == 'pending' ? 'bg-yellow-500' : '' }} {{ $item->status == 'approved' ? 'bg-green-500' : '' }} {{ $item->status == 'rejected' ? 'bg-red-500' : '' }} {{ $item->status == 'completed' ? 'bg-blue-500' : '' }} {{ $item->status == 'cancelled' ? 'bg-gray-500' : '' }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="px-2
                                            py-1">
                                            {{ $item->start_date ? $item->start_date : 'N/A' }} -
                                            {{ $item->end_date ? $item->end_date : 'N/A' }}
                                    </td>
                                    <td class="px-2 py-1">
                                        {{ $item->tgl_selesai ? $item->tgl_selesai : 'N/A' }}
                                    </td>
                                    @if (auth()->user()->isAdmin())
                                        <td class="px-2 py-1">{{ $item->cabang->name ?? 'N/A' }}</td>
                                        <td class="px-2 py-1">{{ $item->user->name ?? 'N/A' }}</td>
                                    @endif
                                    <td class="px-2 py-2">
                                        <div class="flex justify-center flex-wrap gap-2">
                                            <a class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600"
                                                href="{{ route('pengajuanproker.show', $item->id) }}">Lihat</a>
                                            @if (auth()->user()->isAdmin())
                                                @if ($item->status == 'pending')
                                                    <form
                                                        onsubmit="return otherIntercept('Apakah Anda yakin ingin menyetujui item ini?')"
                                                        action="{{ route('pengajuanproker.approve', $item->id) }}"
                                                        method="post" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 cursor-pointer"
                                                            type="submit">Setujui</button>
                                                    </form>
                                                    <form
                                                        onsubmit="return otherIntercept('Apakah Anda yakin ingin menolak item ini?')"
                                                        action="{{ route('pengajuanproker.reject', $item->id) }}"
                                                        method="post" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 cursor-pointer"
                                                            type="submit">Tolak</button>
                                                    </form>
                                                @endif
                                            @else
                                                @if ($item->status == 'pending' || $item->status == 'approved')
                                                    <a class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600"
                                                        href="{{ route('pengajuanproker.edit', $item->id) }}">
                                                        {{ $item->status == 'pending' ? 'Edit' : 'Review' }}
                                                    </a>
                                                @endif
                                                @if ($item->status == 'pending')
                                                    <form onsubmit="deleteIntercept(event)"
                                                        action="{{ route('pengajuanproker.destroy', $item->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600"
                                                            type="submit">Hapus</button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($myprogramkerja->isEmpty())
                    <div class="py-2">
                        <p class="text-center">Tidak ada data program kerja.</p>
                    </div>
                @else
                    <div id="pagination" class="flex justify-between items-center py-2">
                        <a
                            href="{{ $page > 1 ? route('pengajuanproker.index', ['tab' => $programkerjatab, 'page' => $page - 1]) : '' }}">&laquo;
                            Prev</a>
                        <div>Page {{ $page }} of {{ $totalPages }}</div>
                        <a
                            href="{{ $page < $totalPages ? route('pengajuanproker.index', ['tab' => $programkerjatab, 'page' => $page + 1]) : '' }}">Next
                            &raquo;</a>
                    </div>
                @endif
            </aside>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        function otherIntercept(msg) {
            return confirm(msg);
        }

        function deleteIntercept(event) {
            event.preventDefault();
            const form = event.target;
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                form.submit();
            }
        }
    </script>
@endpush
