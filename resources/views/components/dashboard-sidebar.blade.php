@php
    $nav = [
        'Cabang' => route('dashboard.cabang.index'),
        'User' => route('dashboard.user.index'),
        'Program Kerja' => route('dashboard.programkerja.index'),
    ];
@endphp
<button id="sidebar-opener" class="block xl:hidden text-black mb-2">
    <svg class="w-6 h-6 text-gray-800 duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
        height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
    </svg>
</button>
<aside id="sidebar"
    class="bg-white xl:w-1/5 p-4 z-20 xl:p-0 -left-full xl:left-auto fixed duration-500 shadow xl:shadow-none">
    <section id="profile" class="relative mb-2 flex items-center gap-2 bg-accent-1/50 p-2 rounded-md text-white">
        <aside class="w-14 aspect-square">
            <svg class="w-full h-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </aside>
        <aside>
            <h2 class="font-semibold text-xl">{{ Auth::user()->name }}</h2>
            <p class="opacity-75">{{ Auth::user()->role }}</p>
        </aside>
    </section>
    <nav class="flex flex-col gap-2">
        @foreach ($nav as $key => $url)
            <a class="{{ str_contains(Request::url(), $url) ? 'bg-accent-1/50 text-white rounded-md' : '' }} px-2 py-1"
                href="{{ $url }}">{{ $key }}</a>
        @endforeach
    </nav>
</aside>
