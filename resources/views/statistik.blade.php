@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8 flex flex-col gap-4">
        <h2 class="font-semibold text-2xl">Statistik</h2>
        <section id="rank" class="grid grid-cols-3 gap-4">
            @if ($mostApprovedAlltime)
                <div class="shadow p-2 rounded-lg">
                    <h3 class="text-center">Cabang dengan Program Terbanyak Sepanjang masa</h3>
                    <p class="font-semibold text-center">{{ $mostApprovedAlltime['cabang_name'] }}</p>
                    <p class="font-bold text-2xl text-center">{{ $mostApprovedAlltime['total'] }} Program Kerja</p>
                </div>
            @endif
            @if ($mostApproved)
                <div class="shadow p-2 rounded-lg">
                    <h3 class="text-center">Cabang dengan Program Terbanyak Tahun {{ $thisyear }}</h3>
                    <p class="font-semibold text-center">{{ $mostApproved['cabang_name'] }}</p>
                    <p class="font-bold text-2xl text-center">{{ $mostApproved['total'] }} Program Kerja</p>
                </div>
            @endif
            @if ($longest)
                <div class="shadow p-2 rounded-lg">
                    <h3 class="text-center">Program Terlama Tahun {{ $thisyear }}</h3>
                    <p class="font-semibold text-center">{{ $longest['cabang_name'] }} - {{ $longest['name'] }}
                        ({{ $longest['id'] }})</p>
                    <p class="font-bold text-2xl text-center">{{ $longest['max_duration'] }} hari</p>
                </div>
            @endif
            @if ($mostExpensive)
                <div class="shadow p-2 rounded-lg">
                    <h3 class="text-center">Program Termahal</h3>
                    <p class="font-semibold text-center">{{ $mostExpensive['cabang_name'] }} -
                        {{ $mostExpensive['name'] }} ({{ $mostExpensive['id'] }})
                    </p>
                    <p class="font-bold text-2xl text-center">
                        Rp {{ number_format($mostExpensive['max_budget'], 2, ',', '.') }}</p>
                </div>
            @endif
            @if ($cheapest)
                <div class="shadow p-2 rounded-lg">
                    <h3 class="text-center">Program Termurah</h3>
                    <p class="font-semibold text-center">{{ $cheapest['cabang_name'] }} - {{ $cheapest['name'] }}
                        ({{ $cheapest['id'] }})
                    </p>
                    <p class="font-bold text-2xl text-center">Rp {{ number_format($cheapest['min_budget'], 2, ',', '.') }}
                    </p>
                </div>
            @endif
        </section>
        <section id="graphs" class="grid md:grid-cols-2">
            <div id="graph-all" class="overflow-x-auto overflow-y-hidden">
                <div class="w-screen md:w-[75vw] xl:w-[50vw]"></div>
            </div>
            <div id="graph-pending" class="overflow-x-auto overflow-y-hidden">
                <div class="w-screen md:w-[75vw] xl:w-[50vw]"></div>
            </div>
            <div id="graph-approved" class="overflow-x-auto overflow-y-hidden">
                <div class="w-screen md:w-[75vw] xl:w-[50vw]"></div>
            </div>
            <div id="graph-rejected" class="overflow-x-auto overflow-y-hidden">
                <div class="w-screen md:w-[75vw] xl:w-[50vw]"></div>
            </div>
            <div id="graph-completed" class="overflow-x-auto overflow-y-hidden">
                <div class="w-screen md:w-[75vw] xl:w-[50vw]"></div>
            </div>
            <div id="graph-canceled" class="overflow-x-auto overflow-y-hidden">
                <div class="w-screen md:w-[75vw] xl:w-[50vw]"></div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        function addstatuses(...arrays) {
            if (arrays.length === 0) return [];
            return arrays[0].map((array, i) => {
                return array.map((value, j) => {
                    return arrays.reduce((sum, arr) => sum + (arr[i][j] || 0), 0);
                });
            });
        }

        function addcabangs(...arrays) {
            if (arrays.length === 0) return [];
            return arrays[0].map((_, i) => {
                return arrays.reduce((sum, arr) => sum + (arr[i] || 0), 0);
            });
        }

        onloads.push(() => {
            const status = Object.values(@json($status));
            const pending = status.map(s => s.status.pending);
            const approved = status.map(s => s.status.approved);
            const rejected = status.map(s => s.status.rejected);
            const completed = status.map(s => s.status.completed);
            const canceled = status.map(s => s.status.canceled);

            const approvedCombined = addstatuses(approved, completed, canceled);
            const approvedCombinedTotal = addcabangs(...approvedCombined);
            const pendingTotal = addcabangs(...pending);
            const rejectedTotal = addcabangs(...rejected);
            const completedTotal = addcabangs(...completed);
            const canceledTotal = addcabangs(...canceled);
            const all = addstatuses(approvedCombined, canceled, pending);
            const allTotal = addcabangs(...all);

            const cabangNames = [...status.map(s => s.cabang_name), "Semua"];

            var options = Charts.multiLineChart(
                "Jumlah Program Kerja",
                {{ json_encode($years) }},
                [...all, allTotal],
                cabangNames
            );
            var chartall = new ApexCharts(document.querySelector("#graph-all > div"), options);
            chartall.render();

            var options = Charts.multiLineChart(
                "Jumlah Program Kerja Diajukan",
                {{ json_encode($years) }},
                [...pending, pendingTotal],
                cabangNames
            );
            var chartpending = new ApexCharts(document.querySelector("#graph-pending > div"), options);
            chartpending.render();

            var options = Charts.multiLineChart(
                "Jumlah Program Kerja Disetujui",
                {{ json_encode($years) }},
                [...approvedCombined, approvedCombinedTotal],
                cabangNames
            );
            var chartapproved = new ApexCharts(document.querySelector("#graph-approved > div"), options);
            chartapproved.render();

            var options = Charts.multiLineChart(
                "Jumlah Program Kerja Ditolak",
                {{ json_encode($years) }},
                [...rejected, rejectedTotal],
                cabangNames
            );
            var chartrejected = new ApexCharts(document.querySelector("#graph-rejected > div"), options);
            chartrejected.render();

            var options = Charts.multiLineChart(
                "Jumlah Program Kerja Diselesaikan",
                {{ json_encode($years) }},
                [...completed, completedTotal],
                cabangNames
            );
            var chartcompleted = new ApexCharts(document.querySelector("#graph-completed > div"), options);
            chartcompleted.render();

            var options = Charts.multiLineChart(
                "Jumlah Program Kerja Dibatalkan",
                {{ json_encode($years) }},
                [...canceled, canceledTotal],
                cabangNames
            );
            var chartcanceled = new ApexCharts(document.querySelector("#graph-canceled > div"), options);
            chartcanceled.render();
        });
    </script>
@endpush
