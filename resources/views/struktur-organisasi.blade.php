@extends('layouts.base')
@section('content')
    <main class="min-h-[calc(100vh-16rem)] flex flex-col items-center justify-center gap-8 p-8">
        <img class="absolute -z-10 opacity-25" src="/images/airnav-background.png" alt="airnav">
        <h2 class="text-center font-black text-5xl text-accent-1" data-aos="fade-down">
            Struktur AOC <br> Ksatria
        </h2>
        <section id="struktur" class="max-w-screen overflow-scroll scrollbar-hidden" data-aos="fade-up">
            {{-- <div class="w-[200vw] md:w-full">
                <img class="w-full" src="/images/struktur-organisasi.svg" alt="struktur organisasi">
            </div> --}}
            <div id="svg-tree" class="w-full"></div>
        </section>
    </main>
    <div class="modal micromodal-slide" id="modal-struktur" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container w-[90vw] md:w-[50vw]" role="dialog" aria-modal="true"
                aria-labelledby="modal-struktur-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-struktur-title">
                        Struktur AOC
                    </h2>
                    <button class="modal__close cursor-pointer" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-struktur-content">
                    <div class="flex flex-col items-center">
                        <p class="w-full text-center bg-blue-500 text-white px-4 py-1 rounded-lg">Role Model</p>
                        <p id="rolemodel" class="w-full text-center bg-white border mt-1 px-4 py-1 rounded-lg">Para General Manager</p>
                        <svg class="w-6 h-6 text-gray-800 my-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19V5m0 14-4-4m4 4 4-4" />
                        </svg>
                        <p class="w-full text-center bg-blue-500 text-white px-4 py-1 rounded-lg">Change Leader (Kaisar)</p>
                        <p id="kaisar" class="w-full text-center bg-white border mt-1 px-4 py-1 rounded-lg"></p>
                        <svg class="w-6 h-6 text-gray-800 my-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19V5m0 14-4-4m4 4 4-4" />
                        </svg>
                        <p class="w-full text-center bg-blue-500 text-white px-4 py-1 rounded-lg">Change Agent (Ksatria)</p>
                        <p class="w-full text-center bg-white border mt-1 px-4 py-1 rounded-lg">Para Ksatria</p>
                        <svg class="w-6 h-6 text-gray-800 my-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19V5m0 14-4-4m4 4 4-4" />
                        </svg>
                        <p class="w-full text-center bg-blue-500 text-white px-4 py-1 rounded-lg">Change Target</p>
                        <p class="w-full text-center bg-white border mt-1 px-4 py-1 rounded-lg">Seluruh Karyawan di Lokasi</p>
                    </div>
                </main>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function openModal({
            id,
            kaisar
        }) {
            if (id == 0) {
                return;
            }
            document.getElementById('kaisar').innerHTML = !kaisar || kaisar == "" ? "Manager Administrasi & Keuangan" :
                kaisar;
            MicroModal.show("modal-struktur");
        }

        onloads.push(() => {
            const data = {
                "id": "0",
                "data": {
                    "id": 0,
                    "name": "Pusat",
                },
                "children": @json($cabangs->toArray()),
            };

            const options = {
                contentKey: 'data',
                width: "90vw",
                nodeWidth: 200,
                nodeHeight: 50,
                nodeBGColor: "#0000",
                nodeBGColorHover: '#0000',
                borderWidth: 0,
                direction: 'top',
                canvasStyle: '',
                nodeTemplate: (content) => {
                    return `<button onclick='openModal(${JSON.stringify(content)})' class="p-4 bg-blue-500 text-white w-full h-full flex justify-center items-center cursor-pointer">${content.name}</button>`;
                },
            };

            const tree = new ApexTree(document.getElementById('svg-tree'), options);
            const graph = tree.render(data);
        });
    </script>
@endpush
