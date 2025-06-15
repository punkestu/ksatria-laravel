@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="flex justify-end w-full">
        <a class="bg-accent-4 text-white px-4 py-1 rounded-md mb-4"
            href="{{ route('dashboard.programkerja.create') }}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="p-1 w-3">No</th>
                    <th class="p-1 w-3">ID</th>
                    <th class="text-left p-1 w-2/3">Nama Program Kerja</th>
                    <th class="p-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programKerjas as $item)
                    <tr class="border-b border-black/10 {{ $loop->index % 2 == 0 ? 'bg-slate-50' : '' }} hover:bg-slate-100">
                        <td class="px-2 py-1">{{ $loop->iteration }}</td>
                        <td class="px-2 py-1">{{ $item->id }}</td>
                        <td class="px-2 py-1">{{ $item->name }}</td>
                        <td class="flex justify-center gap-2 px-2 py-1">
                            <a class="bg-blue-500 text-white px-2 py-1 rounded-md"
                                href="{{ route('dashboard.programkerja.show', $item->id) }}">Lihat</a>
                            <a class="bg-yellow-500 text-white px-2 py-1 rounded-md"
                                href="{{ route('dashboard.programkerja.edit', $item->id) }}">Edit</a>
                            <form onsubmit="deleteIntercept(event)"
                                action="{{ route('dashboard.programkerja.destroy', $item->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 rounded-md cursor-pointer"
                                    type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($programKerjas->isEmpty())
        <div class="py-2">
            <p class="text-center">Tidak ada data program kerja.</p>
        </div>
    @endif
@endsection
@push('scripts')
    <script>
        function deleteIntercept(event) {
            event.preventDefault();
            const form = event.target;
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                form.submit();
            }
        }
    </script>
@endpush
