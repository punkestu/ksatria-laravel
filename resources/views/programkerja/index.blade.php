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
                <a href="{{ route('pengajuanproker.create', ['tab' => $programkerja->name]) }}">Tambah</a>
            @endif
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="p-1 w-3">ID</th>
                        <th class="text-left p-1 w-1/4">Nama Program Kerja</th>
                        <th class="text-left p-1 w-1/3">Deskripsi</th>
                        <th class="text-left p-1 w-1/6">Status</th>
                        @if (auth()->user()->isAdmin())
                            <th class="text-left p-1 w-1/6">Cabang</th>
                            <th class="text-left p-1 w-1/6">Dibuat Oleh</th>
                        @endif
                        <th class="p-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myprogramkerja as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                {{ Str::limit($item->description, 100) }}
                            </td>
                            <td>
                                {{ [
                                    'pending' => 'Pending',
                                    'approved' => 'Approved',
                                    'rejected' => 'Rejected',
                                    'completed' => 'Completed',
                                ][$item->status] ?? 'Unknown' }}
                            </td>
                            @if (auth()->user()->isAdmin())
                                <td>{{ $item->cabang->name ?? 'N/A' }}</td>
                                <td>{{ $item->user->name ?? 'N/A' }}</td>
                            @endif
                            <td class="flex justify-center gap-2">
                                <a href="{{ route('pengajuanproker.show', $item->id) }}">Lihat</a>
                                @if (auth()->user()->isAdmin())
                                    @if ($item->status == 'pending')
                                        <form
                                            onsubmit="return otherIntercept('Apakah Anda yakin ingin menyetujui item ini?')"
                                            action="{{ route('pengajuanproker.approve', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit">Approve</button>
                                        </form>
                                        <form onsubmit="return otherIntercept('Apakah Anda yakin ingin menolak item ini?')"
                                            action="{{ route('pengajuanproker.reject', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit">Tolak</button>
                                        </form>
                                    @elseif ($item->status == 'approved')
                                        <form
                                            onsubmit="return otherIntercept('Apakah Anda yakin ingin menyelesaikan item ini?')"
                                            action="{{ route('pengajuanproker.complete', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit">Selesaikan</button>
                                        </form>
                                        <form
                                            onsubmit="return otherIntercept('Apakah Anda yakin ingin membatalkan item ini?')"
                                            action="{{ route('pengajuanproker.cancel', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit">Batalkan</button>
                                        </form>
                                    @endif
                                @else
                                    @if ($item->status == 'pending' || $item->status == 'approved')
                                        <a href="{{ route('pengajuanproker.edit', $item->id) }}">Edit</a>
                                    @endif
                                    @if ($item->status == 'pending')
                                        <form onsubmit="deleteIntercept(event)"
                                            action="{{ route('pengajuanproker.destroy', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Hapus</button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
