@extends('layouts.base')
@section('content')
    <main class="min-h-screen">
        <section class="p-4">
            @include('components.userprofile-sidebar')
            <aside class="place-self-end w-full xl:w-3/4">
                <h2 class="font-semibold text-2xl">Profil</h2>
                <hr class="mb-2">
                <section class="flex flex-col items-center justify-center">
                    <div class="w-14 aspect-square">
                        <svg class="w-full h-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <h2 class="text-xl">{{ Auth::user()->name }}</h2>
                    <p class="opacity-75">{{ Auth::user()->role }}</p>
                    <table>
                        <tr>
                            <td class="p-1">
                                Email:
                            </td>
                            <td class="p-1">
                                {{ Auth::user()->email }}
                            </td>
                        </tr>
                    </table>
                </section>
            </aside>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        onloads.push(() => {
            $("#sidebar-opener").click(() => {
                $("#sidebar").toggleClass("-left-full left-0");
                $("#sidebar-opener svg").toggleClass("rotate-180");
            })
        });
    </script>
@endpush
