@extends('layouts.base')
@section('content')
    <main class="min-h-[calc(100vh-16rem)] flex flex-col items-center justify-center gap-8 p-8">
        <img class="absolute -z-30 opacity-25 h-full" src="/images/champion-logo.png" alt="airnav">
        <h2 class="text-center font-black text-5xl text-accent-1" data-aos="fade-down">
            Struktur AOC <br> Ksatria
        </h2>
        <div class="bg-white w-full border flex items-center rounded-md">
            <input class="w-full p-2 text-center outline-none border-transparent focus:border-transparent focus:ring-0" type="search" id="search" onkeyup="search(this)">
            <svg class="w-6 h-6 text-gray-800 m-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
            </svg>
        </div>
        <section id="struktur" class="max-w-screen overflow-scroll scrollbar-hidden flex flex-wrap justify-center gap-2"
            data-aos="fade-up">
            @foreach ($cabangs as $cabang)
                <button onclick='setModal(@json($cabang))'
                    class="px-4 py-2 bg-accent-4/75 text-accent-1 font-semibold rounded-md hover:bg-accent-3 duration-300">
                    {{ $cabang->name }}
                </button>
            @endforeach
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
                        <p id="rolemodel" class="w-full text-center bg-white border mt-1 px-4 py-1 rounded-lg">Para General
                            Manager</p>
                        <svg class="w-6 h-6 text-gray-800 my-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19V5m0 14-4-4m4 4 4-4" />
                        </svg>
                        <p class="w-full text-center bg-blue-500 text-white px-4 py-1 rounded-lg">Change Leader (Kaisar)</p>
                        <p id="kaisar" class="w-full text-center bg-white border mt-1 px-4 py-1 rounded-lg"></p>
                        <svg class="w-6 h-6 text-gray-800 my-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19V5m0 14-4-4m4 4 4-4" />
                        </svg>
                        <p class="w-full text-center bg-blue-500 text-white px-4 py-1 rounded-lg">Change Agent (Ksatria)</p>
                        <p id="ksatria" class="w-full text-center bg-white border mt-1 px-4 py-1 rounded-lg">Para Ksatria
                        </p>
                        <svg class="w-6 h-6 text-gray-800 my-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19V5m0 14-4-4m4 4 4-4" />
                        </svg>
                        <p class="w-full text-center bg-blue-500 text-white px-4 py-1 rounded-lg">Change Target</p>
                        <p class="w-full text-center bg-white border mt-1 px-4 py-1 rounded-lg">Seluruh Karyawan di Lokasi
                        </p>
                    </div>
                </main>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function setModal(cabang) {
            const roleModel = document.getElementById('rolemodel');
            const kaisar = document.getElementById('kaisar');
            const ksatria = document.getElementById('ksatria');

            roleModel.innerText = cabang.rolemodel ?? 'Para General Manager';
            kaisar.innerText = cabang.kaisar ?? 'Para Change Leader';
            ksatria.innerText = cabang.ksatria ?? 'Para Change Agent';

            MicroModal.show('modal-struktur');
        }

        function search(el) {
            const searchValue = el.value.toLowerCase();
            const struktur = document.getElementById('struktur');
            const buttons = struktur.querySelectorAll('button');

            buttons.forEach(button => {
                const buttonText = button.innerText.toLowerCase();
                if (buttonText.includes(searchValue)) {
                    button.style.display = 'inline-block';
                } else {
                    button.style.display = 'none';
                }
            });
        }
    </script>
@endpush
