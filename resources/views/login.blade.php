@extends('layouts.base')
@section('content')
    <main class="min-h-screen flex items-center justify-center p-8">
        <form class="w-full md:w-1/2 xl:w-1/4 flex flex-col gap-2 border rounded-lg p-8" action="{{ route('login.post') }}"
            method="POST" data-aos="fade-down">
            @csrf
            <h2 class="text-center font-black text-5xl text-accent-1 mb-2">
                Login
            </h2>
            <label for="email">Email</label>
            <input class="border px-2 py-1 rounded-sm" type="email" name="email" id="email"
                value="{{ old('email') }}">
            <label for="password">Password</label>
            <div class="flex gap-2 items-center border rounded-sm pe-2">
                <input class="grow px-2 py-1" type="password" name="password" id="password">
                <label for="show-password">
                    <input class="peer hidden" type="checkbox" id="show-password">
                    <svg class="w-6 h-6 text-gray-800 peer-checked:hidden" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2"
                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg class="w-6 h-6 text-gray-800 hidden peer-checked:flex" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </label>
            </div>
            <button class="mt-4 bg-accent-1 hover:bg-accent-1/75 duration-300 text-white px-8 py-1 rounded-full"
                type="submit">Login</button>
        </form>
    </main>
@endsection
@push('scripts')
    <script>
        function onshowpassword() {
            $('#show-password').change(function() {
                if ($(this).is(':checked')) {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
        }
        onloads.push(onshowpassword);
    </script>
@endpush
