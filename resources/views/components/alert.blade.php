@push('scripts')
    <script>
        function toast(type, message) {
            toastr[type](message);
        }
        onloads.push(() => {
            @if (session('alert'))
                @php
                    $alert = session('alert');
                    $alert['type'] = $alert['type'] ?? 'info';
                    $alert['message'] = $alert['message'] ?? 'Ada yang salah';
                @endphp
                toast('{{ $alert['type'] }}', '{{ $alert['message'] }}');
            @endif
            @foreach ((session('alerts') ?? []) as $alert)
                @php
                    $alert['type'] = $alert['type'] ?? 'info';
                    $alert['message'] = $alert['message'] ?? 'Ada yang salah';
                @endphp
                toast('{{ $alert['type'] }}', '{{ $alert['message'] }}');
            @endforeach
        })
    </script>
@endpush
