@extends('layouts.dashboard')
@section('dashboard-content')
    <a href="{{ route('dashboard.user.create') }}">Tambah</a>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="p-1 w-3">ID</th>
                <th class="text-left p-1 w-1/4">Nama User</th>
                <th class="text-left p-1 w-1/6">Role</th>
                <th class="text-left p-1 w-1/4">Email</th>
                <th class="text-left p-1 w-2/3">Cabang</th>
                <th class="p-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        {{ $item->role === 'admin' ? 'Admin' : ($item->role === 'user' ? 'User' : 'Unknown') }}
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->cabang ? $item->cabang->name : 'Tidak ada cabang' }}</td>
                    <td class="flex justify-center gap-2">
                        <a href="{{ route('dashboard.user.show', $item->id) }}">Lihat</a>
                        <a href="{{ route('dashboard.user.edit', $item->id) }}">Edit</a>
                        <form onsubmit="deleteIntercept(event)" action="{{ route('dashboard.user.destroy', $item->id) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($users->isEmpty())
        <div class="py-2">
            <p class="text-center">Tidak ada data user.</p>
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
