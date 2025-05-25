@php
    $colors = [
        'success' => 'bg-green-300',
        'error' => 'bg-red-300',
        'warning' => 'bg-yellow-300',
        'info' => 'bg-blue-300',
    ];
@endphp
<div id="alert" class="z-50 fixed top-0 right-0 p-4 flex flex-col items-end gap-2">
    @if (session('alert'))
        @php
            $alert = session('alert');
            $alert['type'] = $alert['type'] ?? 'info';
            $alert['message'] = $alert['message'] ?? 'Ada yang salah';
            $alert['color'] = $colors[$alert['type']] ?? 'bg-blue-300';
        @endphp
        <div class="{{ $alert['color'] }} ps-4 pe-2 py-1 rounded-md flex justify-between" data-dispose="3000">
            {{ $alert['message'] }}
            <button class="ml-2 text-black" onclick="removealert(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
    @if (session('alerts'))
        @foreach (session('alerts') as $alert)
            @php
                $alert['type'] = $alert['type'] ?? 'info';
                $alert['message'] = $alert['message'] ?? 'Ada yang salah';
                $alert['color'] = $colors[$alert['type']] ?? 'bg-blue-300';
            @endphp
            <div class="{{ $alert['color'] }} ps-4 pe-2 py-1 rounded-md flex justify-between" data-dispose="3000">
                {{ $alert['message'] }}
                <button class="ml-2 text-black" onclick="removealert(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endforeach
    @endif
</div>
@push('scripts')
    <script>
        const alertstack = [];

        function dispatchalertdispose() {
            if (alertstack.length == 0) {
                $("#alert").removeClass('z-50');
                return;
            }
            const _alert = alertstack.shift();
            if (_alert) {
                const dispose = _alert.data('dispose');
                setTimeout(() => {
                    _alert.remove();
                    dispatchalertdispose();
                }, dispose);
            } else {
                dispatchalertdispose();
            }
        }

        function removealert(el) {
            const _alert = $(el).parent();
            const index = alertstack.indexOf(_alert);
            if (index > -1) {
                alertstack.splice(index, 1);
                if (alertstack.length == 0) {
                    $("#alert").removeClass('z-50');
                }
            }
            _alert.remove();
        }

        function pushalert(type, message) {
            const bg = {
                'success': 'bg-green-300',
                'error': 'bg-red-300',
                'warning': 'bg-yellow-300',
                'info': 'bg-blue-300'
            } [type] || 'bg-blue-300';
            const _alert = $(
                `<div class="${bg} ps-4 pe-2 py-1 rounded-md flex justify-between" data-dispose="3000">
                    ${message}
                    <button class="ml-2 text-black" onclick="removealert(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>`
            );
            $('.fixed').append(_alert);
            alertstack.push(_alert);
            if (!$("#alert").hasClass('z-50')) {
                $("#alert").addClass('z-50');
            }
            dispatchalertdispose();
        }

        onloads.push(() => {
            $('[data-dispose]').each(function() {
                const _alert = $(this);
                const dispose = _alert.data('dispose');
                if (dispose) {
                    alertstack.push(_alert);
                }
            });
            if (alertstack.length > 0) {
                dispatchalertdispose();
            } else {
                $("#alert").removeClass('z-50');
            }
        })
    </script>
@endpush
