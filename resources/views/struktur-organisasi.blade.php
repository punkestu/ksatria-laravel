@extends('layouts.base')
@section('content')
    <main class="min-h-screen flex flex-col items-center justify-center gap-8 p-8">
        <img class="absolute -z-10 opacity-25" src="/images/airnav-background.png" alt="airnav">
        <h2 class="text-center font-black text-5xl text-accent-1" data-aos="fade-down">
            Struktur Organisasi <br> Airnav (Ksatria)
        </h2>
        <section id="struktur" class="max-w-screen overflow-scroll scrollbar-hidden" data-aos="fade-up">
            <div class="w-[200vw] md:w-full">
                <img class="w-full" src="/images/struktur-organisasi.svg" alt="struktur organisasi">
            </div>
        </section>
    </main>
@endsection
