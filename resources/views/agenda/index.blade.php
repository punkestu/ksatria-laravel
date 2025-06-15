@extends('layouts.base')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="sync-token-url" content="{{ route('api.auth.getSanctumToken') }}">
@endpush
@section('content')
    <main class="p-4 min-h-screen">
        <section class="flex justify-between mb-2">
            <h2 class="font-semibold text-2xl">Agenda</h2>
            @if (auth()->user()->isAdmin())
                <a class="bg-accent-4 text-white px-4 py-1 rounded hover:bg-accent-5"
                    href="{{ route('agenda.create') }}">Tambah</a>
            @endif
        </section>
        <div id='calendar'></div>
    </main>
@endsection
@push('scripts')
    <script>
        onloads.push(async () => {
            var calendarEl = document.getElementById('calendar');
            if (!isTokenValid()) {
                await syncToken();
            }
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function(info, successCallback, failureCallback) {
                    $.ajax({
                        url: "{{ route('api.agenda.index') }}",
                        type: "GET",
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('sync_token'),
                        },
                        dataType: "json",
                        data: {
                            start_date: info.startStr.split('T')[0],
                            end_date: info.endStr.split('T')[0]
                        },
                        success: function(response) {
                            var events = response.data.map(function(event) {
                                return {
                                    id_event: event.id,
                                    title: event.title,
                                    description: event.description,
                                    start: event.start_time.split(' ').join(
                                        'T'),
                                    end: event.end_time.split(' ').join('T'),
                                };
                            });
                            successCallback(events);
                        },
                        error: function(err) {
                            alert('Terjadi error ketika loading agenda.');
                            failureCallback(err);
                        }
                    })
                },
                eventClick: function(info) {
                    const id = info.event.extendedProps.id_event;
                    window.location.href = `{{ url('agenda') }}/${id}`;
                },
                eventClassNames: function(arg) {
                    return ['cursor-pointer'];
                }
            });
            calendar.render();
        });
    </script>
@endpush
