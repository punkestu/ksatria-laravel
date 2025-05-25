@extends('layouts.dashboard')
@section('dashboard-content')
    <a href="{{ route('dashboard.cabang.create') }}">Tambah</a>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="p-1 w-3">ID</th>
                <th class="text-left p-1 w-2/3">Nama Cabang</th>
                <th class="p-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cabang as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td class="flex justify-center gap-2">
                        <a href="{{ route('dashboard.cabang.show', $item->id) }}">Lihat</a>
                        <a href="{{ route('dashboard.cabang.edit', $item->id) }}">Edit</a>
                        <form onsubmit="deleteIntercept(event)" action="{{ route('dashboard.cabang.destroy', $item->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($cabang->isEmpty())
        <div class="py-2">
            <p class="text-center">Tidak ada data cabang.</p>
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
