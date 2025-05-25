@extends('layouts.base')
@section('content')
    <main class="min-h-screen">
        <section class="p-4">
            @include('components.dashboard-sidebar')
            <aside class="place-self-end w-full xl:w-3/4">
                @yield('dashboard-content')
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