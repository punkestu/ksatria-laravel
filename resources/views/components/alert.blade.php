@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
