@php
    $navbar = [
        'Agenda' => ['url' => route('agenda.index'), 'isadmin' => false, 'redirect' => false],
        'Program Kerja' => ['url' => route('program-kerja'), 'isadmin' => false, 'redirect' => false],
        'Statistik' => ['url' => route('statistic'), 'isadmin' => false, 'redirect' => false],
        'Struktur AOC' => ['url' => route('struktur-organisasi'), 'isadmin' => false, 'redirect' => false],
        'Bantuan' => [
            'url' => 'https://wa.me/+6282198329493?text=Hallo admin👋, Saya mau tanya ...',
            'redirect' => true,
            'isadmin' => false,
        ],
    ];
    $loginurl = route('login');
@endphp

<header class="sticky top-0 flex items-center flex-wrap justify-between gap-2 bg-accent-1 px-4 py-2 text-white z-30">
    <aside class="flex grow xl:grow-0 gap-4 items-center">
        <img class="h-8" src="/images/bumn.svg" alt="BUMN">
        <img class="h-10" src="/images/akhlak.webp" alt="akhlak">
        <img class="h-10" src="/images/airnav.webp" alt="Airnav">
        <a href="/" class="flex h-8">
            <img src="/images/champion-logo-long.webp" alt="champion">
        </a>
    </aside>
    <nav class="flex justify-center md:justify-end items-center grow gap-8">
        @foreach ($navbar as $key => $data)
            <a {{ $data['redirect'] ? "target='_blank'" : '' }}
                class="hidden xl:block hover:text-white/75 duration-300 hover:underline"
                href="{{ $data['url'] }}">{{ $key }}</a>
        @endforeach
        @auth
            @php
                $haveNotification = auth()->user() && auth()->user()->unreadNotifications->count() > 0;
            @endphp
            <a class="{{ $haveNotification ? 'bg-white rounded-full p-1 hover:bg-white/75' : 'hover:text-white/75' }} duration-300 flex"
                href="{{ route('notification') }}">
                @if ($haveNotification)
                    <svg class="w-6 h-6 text-accent-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.193-.538 1.193H5.538c-.538 0-.538-.6-.538-1.193 0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365Zm-8.134 5.368a8.458 8.458 0 0 1 2.252-5.714m14.016 5.714a8.458 8.458 0 0 0-2.252-5.714M8.54 17.901a3.48 3.48 0 0 0 6.92 0H8.54Z" />
                    </svg>
                @else
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z" />
                    </svg>
                @endif
            </a>
            <a class="hover:text-white/75 duration-300 flex" href="{{ route('user-profile') }}">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </a>
            @if (auth()->user()->isAdmin())
                <a class="hover:text-white/75 duration-300 flex" href="{{ route('dashboard.cabang.index') }}">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                </a>
            @endif
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
    class="w-screen flex xl:hidden flex-col fixed -top-full items-center justify-end grow bg-white z-10 transition-all duration-500 ease-in-out shadow">
    @foreach ($navbar as $key => $data)
        @if ($data['isadmin'] && (!auth()->user() || !auth()->user()->isAdmin()))
            @continue
        @endif
        <a class="hover:text-black/75 duration-300 py-2 border-b w-full text-center"
            href="{{ $data['url'] }}">{{ $key }}</a>
    @endforeach
</nav>
@push('scripts')
    <script>
        onloads.push(() => {
            $("#nav-opener").click(() => {
                $("#nav-slide").toggleClass("-top-full top-[5.6rem] md:top-14");
                $("#nav-opener").toggleClass("rotate-180 rotate-0");
            });
        });
    </script>
@endpush
