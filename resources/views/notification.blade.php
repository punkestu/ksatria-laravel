@extends('layouts.base')
@section('content')
    <main class="min-h-screen flex flex-col gap-4 p-8">
        <h2 class="text-center font-black text-5xl text-accent-1">
            Notifikasi
        </h2>
        <section id="notifications" class="w-full flex flex-col gap-2">
            @foreach (auth()->user()->notifications as $notification)
                <a class="{{ $notification->read_at != null ? 'bg-white' : 'bg-accent-4 text-white' }} border w-full px-4 py-2 rounded-lg flex flex-col"
                    href="{{ $notification->data['redirect_url'] }}">
                    <h3 class="font-semibold">{{ $notification->data['type'] }}</h3>
                    <p>{{ $notification->data['message'] }}</p>
                    <p class="opacity-50 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </a>
            @endforeach
        </section>
    </main>
@endsection
