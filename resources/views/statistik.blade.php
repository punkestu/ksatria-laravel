@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8 flex flex-col gap-4 bg-gray-50">
        <h2 class="font-semibold text-2xl">Statistik</h2>
        <section class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
            <div id="lp-dist" class="shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden flex justify-center">
                <div></div>
            </div>
            <div id="pk-dist" class="xl:col-span-2 shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden flex justify-center">
                <div></div>
            </div>
        </section>
        <section id="graphs" class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
            <div id="graph-pending"
                class="xl:col-span-2 shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden">
                <div class="w-screen"></div>
            </div>
            <div id="pkprocess-dist" class="shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden flex justify-center">
                <div></div>
            </div>
            <div id="graph-approved" class="shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden">
                <div class="w-screen md:w-[75vw] xl:w-[50vw]"></div>
            </div>
            <div id="graph-completed"
                class="xl:col-span-2 shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden">
                <div class="w-screen md:w-[75vw]"></div>
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
            const approved = status.map(s => s.status.approved || s.status.completed || s.status.canceled);
            const completed = status.map(s => s.status.completed);

            const approvedTotal = addcabangs(...approved);
            const pendingTotal = addcabangs(...pending);
            const completedTotal = addcabangs(...completed);

            const cabangNames = [...status.map(s => s.cabang_name), "Semua"];

            const karyawanCount = @json($karyawanCountPerGender);
            const cabangRating = @json($ratingCabang);

            const cabangRatingLabels = cabangRating.map(r => r.cabang_name);
            const cabangRatingData = cabangRating.map(r => r.avg_rating);

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
                [...approved, approvedTotal],
                cabangNames
            );
            var chartapproved = new ApexCharts(document.querySelector("#graph-approved > div"), options);
            chartapproved.render();

            var options = Charts.multiLineChart(
                "Jumlah Program Kerja Diselesaikan",
                {{ json_encode($years) }},
                [...completed, completedTotal],
                cabangNames
            );
            var chartcompleted = new ApexCharts(document.querySelector("#graph-completed > div"), options);
            chartcompleted.render();

            var options = Charts.pieChart(
                "Jumlah Karyawan per Gender",
                ["Laki-laki", "Perempuan"],
                [
                    parseInt(karyawanCount["Laki-laki"]) || 0,
                    parseInt(karyawanCount["Perempuan"]) || 0
                ]
            );
            var chart = new ApexCharts(document.querySelector("#lp-dist div"), options);
            chart.render();

            var options = Charts.barChart(
                "Performa Program Kerja Cabang Tahun ini",
                cabangRatingLabels,
                cabangRatingData,
            );
            var chart = new ApexCharts(document.querySelector("#pk-dist"), options);
            chart.render();

            var options = Charts.pieChart(
                "Jumlah Proses Program Kerja",
                ["Diajukan", "Disetujui", "Diselesaikan"],
                [
                    {{ $pendingThisYear }},
                    {{ $approvedThisYear }},
                    {{ $completedThisYear }}
                ]
            );

            var chart = new ApexCharts(document.querySelector("#pkprocess-dist div"), options);
            chart.render();

        });
    </script>
@endpush
