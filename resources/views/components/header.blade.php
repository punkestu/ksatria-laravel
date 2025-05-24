@php
    $navbar = [
        'Profil' => '',
        'Program Kerja' => route('program-kerja'),
        'Statistik' => '',
        'Struktur Organisasi' => route('struktur-organisasi'),
        'Bantuan' => '',
    ];
@endphp

<header class="sticky top-0 flex items-center flex-wrap justify-between bg-accent-1 px-4 py-2 text-white z-30">
    <aside class="flex grow xl:grow-0 gap-4 items-center">
        <img class="h-8" src="/images/bumn.svg" alt="BUMN">
        <img class="h-10" src="/images/akhlak.png" alt="akhlak">
        <img class="h-10" src="/images/airnav.png" alt="Airnav">
        <a href="/" class="flex h-8">
            <img src="/images/champion-logo.svg" alt="champion">
        </a>
    </aside>
    <button id="nav-opener" class="block xl:hidden rotate-0 duration-300">
        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
            height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 9-7 7-7-7" />
        </svg>
    </button>
    <nav class="hidden xl:flex items-center justify-end gap-8 grow">
        @foreach ($navbar as $key => $url)
            <a class="hover:text-white/75 duration-300 hover:underline"
                href="{{ $url }}">{{ $key }}</a>
        @endforeach
        <a class="hover:text-white/75 duration-300" href="">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z" />
            </svg>
        </a>
        <a class="bg-white hover:bg-white/75 duration-300 text-accent-1 px-8 py-1 rounded-full" href="">Login</a>
    </nav>
</header>
<nav id="nav-slide"
    class="w-screen flex flex-col fixed -top-full items-center justify-end grow bg-white z-10 p-4 pt-0 transition-all duration-500 ease-in-out shadow">
    @foreach ($navbar as $key => $url)
        <a class="hover:text-white/75 duration-300 py-2 border-b w-full text-center"
            href="{{ $url }}">{{ $key }}</a>
    @endforeach
    <a class="hover:text-white/75 duration-300 py-2 border-b w-full flex justify-center" href="">
        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z" />
        </svg>
    </a>
    <a class="mt-2 bg-accent-1 hover:bg-accent-1/75 duration-300 text-white px-8 py-1 rounded-full"
        href="">Login</a>
</nav>
