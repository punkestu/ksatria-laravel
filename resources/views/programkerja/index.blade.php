@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8">
        <h2 class="font-semibold text-2xl">Program Kerja</h2>
        <section id="head" class="py-2 overflow-x-scroll scrollbar-hidden">
            <nav id="tabs" class="flex gap-4">
                @foreach ($programkerjas as $item)
                    <a class="{{ $programkerja->name == $item->name ? 'bg-accent-4 text-white' : '' }} px-2 py-1"
                        href="{{ route('pengajuanproker.index', ['tab' => $item->name]) }}">{{ $item->name }}</a>
                @endforeach
            </nav>
        </section>
        <section>
            @if (!auth()->user()->isAdmin())
                <a class="underline cursor-pointer" href="{{ route('pengajuanproker.create', ['tab' => $programkerja->name]) }}">Tambah</a>
            @endif
            <div class="overflow-x-auto">
                <table class="w-[300%] md:w-[175%] xl:w-[110%]">
                    <thead>
                        <tr class="border-b">
                            <th class="px-2 py-1 w-3">ID</th>
                            <th class="text-left px-2 py-1 w-1/6">Nama Program Kerja</th>
                            <th class="text-left px-2 py-1 w-1/5">Deskripsi</th>
                            <th class="text-left px-2 py-1">Status</th>
                            <th class="text-left px-2 py-1">Dari-Sampai</th>
                            @if (auth()->user()->isAdmin())
                                <th class="text-left px-2 py-1">Cabang</th>
                                <th class="text-left px-2 py-1">Dibuat Oleh</th>
                            @endif
                            <th class="px-2 py-1 w-1/6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myprogramkerja as $item)
                            <tr class="border-b border-black/10 {{$loop->index % 2 == 0 ? 'bg-slate-50' : ''}}">
                                <td class="px-2 py-1">{{ $item->id }}</td>
                                <td class="px-2 py-1">{{ $item->name }}</td>
                                <td class="px-2 py-1">
                                    {{ Str::limit($item->description, 50) }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ [
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        'completed' => 'Completed',
                                    ][$item->status] ?? 'Unknown' }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ $item->start_date ? $item->start_date : 'N/A' }} -
                                    {{ $item->end_date ? $item->end_date : 'N/A' }}
                                </td>
                                @if (auth()->user()->isAdmin())
                                    <td class="px-2 py-1">{{ $item->cabang->name ?? 'N/A' }}</td>
                                    <td class="px-2 py-1">{{ $item->user->name ?? 'N/A' }}</td>
                                @endif
                                <td class="px-2 py-1">
                                    <div class="flex justify-center flex-wrap gap-2">
                                        <a class="underline" href="{{ route('pengajuanproker.show', $item->id) }}">Lihat</a>
                                        @if (auth()->user()->isAdmin())
                                            @if ($item->status == 'pending')
                                                <form
                                                    onsubmit="return otherIntercept('Apakah Anda yakin ingin menyetujui item ini?')"
                                                    action="{{ route('pengajuanproker.approve', $item->id) }}"
                                                    method="post" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="underline cursor-pointer" type="submit">Setujui</button>
                                                </form>
                                                <form
                                                    onsubmit="return otherIntercept('Apakah Anda yakin ingin menolak item ini?')"
                                                    action="{{ route('pengajuanproker.reject', $item->id) }}"
                                                    method="post" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="underline cursor-pointer" type="submit">Tolak</button>
                                                </form>
                                            @elseif ($item->status == 'approved')
                                                <form
                                                    onsubmit="return otherIntercept('Apakah Anda yakin ingin menyelesaikan item ini?')"
                                                    action="{{ route('pengajuanproker.complete', $item->id) }}"
                                                    method="post" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="underline cursor-pointer" type="submit">Selesaikan</button>
                                                </form>
                                                <form
                                                    onsubmit="return otherIntercept('Apakah Anda yakin ingin membatalkan item ini?')"
                                                    action="{{ route('pengajuanproker.cancel', $item->id) }}"
                                                    method="post" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="underline cursor-pointer" type="submit">Batalkan</button>
                                                </form>
                                            @endif
                                        @else
                                            @if ($item->status == 'pending' || $item->status == 'approved')
                                                <a href="{{ route('pengajuanproker.edit', $item->id) }}">Edit</a>
                                            @endif
                                            @if ($item->status == 'pending')
                                                <form onsubmit="deleteIntercept(event)"
                                                    action="{{ route('pengajuanproker.destroy', $item->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">Hapus</button>
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
            @endif
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
