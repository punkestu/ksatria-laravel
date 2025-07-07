@extends('layouts.base')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="sync-token-url" content="{{ route('api.auth.getSanctumToken') }}">
@endpush
@section('content')
    <main class="min-h-screen p-8 flex flex-col gap-4 bg-gray-50">
        <h2 class="font-semibold text-2xl">Statistik</h2>
        <section class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
            <div id="lp-dist" class="shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden flex justify-center">
                <div></div>
            </div>
            <div id="pk-dist"
                class="xl:col-span-2 shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden flex justify-center">
                <div></div>
            </div>
        </section>
        <section id="graphs" class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
            <div id="graph-pending" class="shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden">
                <div class="w-screen"></div>
            </div>
            <div id="cabang-dist" class="shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden">
                <div>
                    <h4 class="text-sm font-medium">Distribusi Program Kerja tiap Cabang</h4>
                    <input class="w-full border px-2 py-1 my-2 rounded-md" placeholder="Cari cabang..." type="search"
                        name="search_cabang" id="search_cabang" onkeyup="searchcabang(this)">
                    <div class="flex gap-2 flex-wrap overflow-y-auto max-h-72">
                        @foreach ($cabangs as $cabang)
                            <button class="border p-2 rounded-md cursor-pointer"
                                onclick="setdistproker({{ $cabang->id }})">
                                {{ $cabang->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="pkprocess-dist"
                class="shadow p-4 bg-white rounded-lg overflow-x-auto overflow-y-hidden flex justify-center">
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
    <div class="modal micromodal-slide" id="modal-distproker" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container w-[90vw] md:w-[50vw]" role="dialog" aria-modal="true"
                aria-labelledby="modal-distproker-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-distproker-title">
                        Distribusi Program Kerja
                    </h2>
                    <button class="modal__close cursor-pointer" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-distproker-content">
                </main>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function searchcabang(el) {
            const search = el.value.toLowerCase();
            const buttons = document.querySelectorAll("#cabang-dist button");
            buttons.forEach(button => {
                const text = button.textContent.toLowerCase();
                if (text.includes(search)) {
                    button.style.display = "inline-block";
                } else {
                    button.style.display = "none";
                }
            });
        }

        async function setdistproker(cabangId) {
            const modal = document.getElementById('modal-distproker');
            const content = document.getElementById('modal-distproker-content');
            content.innerHTML = `<div class="flex justify-center items-center h-full">Loading...</div>`;
            MicroModal.show('modal-distproker');

            if (!isTokenValid()) {
                await syncToken();
            }

            $.ajax({
                url: '{{ route('api.dist_proker.index') }}?cabang_id=' + cabangId,
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('sync_token'),
                },
                dataType: "json",
                success: function(data) {
                    if (data.data.length === 0) {
                        content.innerHTML =
                            `<div class="text-red-500">Tidak ada data distribusi program kerja untuk cabang ini.</div>`;
                        return;
                    }

                    content.innerHTML = `<h2 class="text-lg font-semibold mb-4">${data.cabang}</h2>`;
                    content.innerHTML += '<div id="distproker-dist"></div>';

                    var options = Charts.pieChart(
                        "",
                        Object.keys(data.data),
                        Object.values(data.data)
                    );
                    var chart = new ApexCharts(document.querySelector("#distproker-dist"), options);
                    chart.render();
                },
                error: function(xhr, status, error) {
                    toast('error', 'Gagal memuat data',
                        'Terjadi kesalahan saat memuat data distribusi program kerja.');
                    content.innerHTML = `<div class="text-red-500">Failed to load</div>`;
                }
            });
        }

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
