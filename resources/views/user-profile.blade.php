@extends('layouts.base')
@section('content')
    <main class="min-h-screen">
        <section id="profile">
            <h2>{{ Auth::user()->name }}</h2>
        </section>
        <section class="flex items-start gap-4">
            <aside
                class="h-[calc(100vh-5.5rem)] md:h-[calc(100vh-3.5rem)] w-1/5 p-4 flex flex-col justify-between">
                <nav>
                    <a class="bg-accent-1/50" href="{{ route('user-profile') }}">Profile</a>
                </nav>
                <a href="{{ route('logout') }}">Logout</a>
            </aside>
            <aside class="grow border self-stretch">

            </aside>
        </section>
    </main>
@endsection
