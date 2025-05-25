@php
    $navbar = [
        'Profil' => '',
        'Program Kerja' => route('program-kerja'),
        'Statistik' => '',
        'Struktur Organisasi' => route('struktur-organisasi'),
        'Bantuan' => '',
    ];
    $loginurl = route('login');
@endphp

<header class="sticky top-0 flex items-center flex-wrap justify-between gap-2 bg-accent-1 px-4 py-2 text-white z-30">
    <aside class="flex grow xl:grow-0 gap-4 items-center">
        <img class="h-8" src="/images/bumn.svg" alt="BUMN">
        <img class="h-10" src="/images/akhlak.png" alt="akhlak">
        <img class="h-10" src="/images/airnav.png" alt="Airnav">
        <a href="/" class="flex h-8">
            <img src="/images/champion-logo.svg" alt="champion">
        </a>
    </aside>
    <nav class="flex justify-center md:justify-end items-center grow gap-8">
        @foreach ($navbar as $key => $url)
            <a class="hidden xl:block hover:text-white/75 duration-300 hover:underline"
                href="{{ $url }}">{{ $key }}</a>
        @endforeach
        @auth
            <a class="hover:text-white/75 duration-300 flex" href="">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z" />
                </svg>
            </a>
            <a class="hover:text-white/75 duration-300 flex" href="{{ route('user-profile') }}">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </a>
        @endauth
        @guest
            <a class="bg-white hover:bg-white/75 duration-300 text-accent-1 px-8 py-1 rounded-full"
                href="{{ $loginurl }}">Login</a>
        @endguest
        <button id="nav-opener" class="block xl:hidden rotate-0 duration-300 hover:cursor-pointer">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 9-7 7-7-7" />
            </svg>
        </button>
    </nav>
</header>
<nav id="nav-slide"
    class="w-screen flex flex-col fixed -top-full items-center justify-end grow bg-white z-10 transition-all duration-500 ease-in-out shadow">
    @foreach ($navbar as $key => $url)
        <a class="hover:text-black/75 duration-300 py-2 border-b w-full text-center"
            href="{{ $url }}">{{ $key }}</a>
    @endforeach
</nav>
@push('scripts')
    <script>
        onloads.push(() => {
            $("#nav-opener").click(() => {
                $("#nav-slide").toggleClass("-top-full top-[6rem] md:top-14");
                $("#nav-opener").toggleClass("rotate-180 rotate-0");
            });
        });
    </script>
@endpush
