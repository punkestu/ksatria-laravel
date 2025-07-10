@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="sync-token-url" content="{{ route('api.auth.getSanctumToken') }}">
@endpush
@extends('layouts.base')
@section('content')
    <main class="min-h-screen p-8">
        <a href="{{ route('pengajuanproker.index', ['tab' => $programkerja->name]) }}">Kembali</a>
        <form action="{{ route('pengajuanproker.update', $pengajuanproker->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="program_kerja_id" class="block text-sm font-medium text-gray-700">Program Kerja</label>
                <select id="program_kerja_id" name="program_kerja_id" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm read-only:bg-gray-50"
                    {{ $pengajuanproker->status == 'pending' ? '' : 'readonly' }}>
                    @if ($pengajuanproker->status == 'pending')
                        <option value="">Pilih Program Kerja</option>
                    @endif
                    @foreach ($programkerjas as $proker)
                        @if ($pengajuanproker->status != 'pending' && $proker->id != $pengajuanproker->program_kerja_id)
                            @continue
                        @endif
                        <option value="{{ $proker->id }}"
                            {{ (old('program_kerja_id') ?? $pengajuanproker->program_kerja_id) == $proker->id ? 'selected' : '' }}>
                            {{ $proker->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('program_kerja_id'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('program_kerja_id') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm read-only:bg-gray-50"
                    value="{{ old('name') ?? $pengajuanproker->name }}"
                    {{ $pengajuanproker->status == 'pending' ? '' : 'readonly' }}>
                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm read-only:bg-gray-50"
                    {{ $pengajuanproker->status == 'pending' ? '' : 'readonly' }}>{{ old('description') ?? $pengajuanproker->description }}</textarea>
                @if ($errors->has('description'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('description') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm read-only:bg-gray-50"
                    value="{{ old('start_date') ?? $pengajuanproker->start_date }}"
                    {{ $pengajuanproker->status == 'pending' ? '' : 'readonly' }}>
                @if ($errors->has('start_date'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('start_date') }}</p>
                @endif
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" required
                    class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm read-only:bg-gray-50"
                    value="{{ old('end_date') ?? $pengajuanproker->end_date }}"
                    {{ $pengajuanproker->status == 'pending' ? '' : 'readonly' }}>
                @if ($errors->has('end_date'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('end_date') }}</p>
                @endif
            </div>
            @if ($pengajuanproker->status === 'approved')
                <hr class="my-2">
                {{-- finish_date --}}
                <div class="mb-4">
                    <label for="finish_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" id="finish_date" name="finish_date" required
                        class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm read-only:bg-gray-50"
                        value="{{ old('finish_date') }}">
                    @if ($errors->has('finish_date'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('finish_date') }}</p>
                    @endif
                </div>
                {{-- resources --}}
                <div class="mb-4">
                    <label for="resources" class="block text-sm font-medium text-gray-700">Berkas (Bukti kegiatan, Struk,
                        dll)</label>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach (old('resource') ?? $pengajuanproker->resources as $resource)
                            <div class="w-32 aspect-square relative">
                                <img class="h-full w-full object-cover" src="{{ $resource['url'] ?? $resource->url }}"
                                    alt="resource_{{ $loop->index }}" onerror="">
                                <input type="hidden" name="resource[{{ $loop->index }}][resource_id]"
                                    value="{{ $resource['id'] ?? $resource->id }}">
                                <input type="hidden" name="resource[{{ $loop->index }}][url]"
                                    value="{{ $resource['url'] ?? $resource->url }}">
                                <button type="button" onclick="deleteresource(this)"
                                    class="bg-gray-500/30 opacity-0 hover:opacity-100 duration-300 absolute top-0 left-0 w-full h-full flex justify-center items-center">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                        <button id="add-resource-btn" type="button" popovertarget="popover-add-resource"
                            class="bg-gray-500/30 hover:bg-gray-500/100 duration-300 w-32 aspect-square flex justify-center items-center">
                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>
                        </button>
                    </div>
                    @if ($errors->has('resources'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('resources') }}</p>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" required
                        class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm read-only:bg-gray-50">{{ old('keterangan') ?? $pengajuanproker->keterangan }}</textarea>
                    @if ($errors->has('keterangan'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('keterangan') }}</p>
                    @endif
                </div>
            @endif
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ $pengajuanproker->status === 'approved' ? 'Selesaikan' : 'Simpan' }}
            </button>
        </form>
    </main>
    <div class="bg-white shadow-lg p-6 rounded-xl md:w-2/3 xl:w-1/2 max-h-[75vh] overflow-y-auto
           fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50"
        id="popover-add-resource" popover>
        <h3 class="text-lg mb-4">Tambah Berkas</h3>
        <form class="flex flex-col gap-2" onsubmit="uploadresource(event)">
            <input class="border px-2 py-1 rounded-md" type="file" name="file" id="file"
                accept=".jpg, .jpeg, .png, .gif, .pdf">
            <input class="border px-2 py-1 rounded-md" placeholder="Url Berkas" type="text" name="fileurl"
                id="fileurl">
            <button class="bg-accent-1 text-white px-2 py-1 rounded-lg" type="submit">Upload</button>
        </form>
        <div id="popover-resource-container" class="flex flex-wrap justify-center gap-2 pt-2">
            Loading...
        </div>
    </div>
    <template>
        <div data-template="resource-card" class="w-32 aspect-square relative">
            <img class="h-full w-full object-cover" src="" alt=""
                onerror="this.src='/images/berkas.svg'">
            <input type="hidden" data-role="resource_id" name="resource[][resource_id]">
            <input type="hidden" data-role="resource_url" name="resource[][url]">
            <button type="button" onclick="deleteresource(this)" title=""
                class="bg-gray-500/30 opacity-0 hover:opacity-100 duration-300 absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
                <p class="text-xs text-white"></p>
            </button>
        </div>
        <button data-template="popover-resource-item" type="button" class="w-32 aspect-square border rounded-md p-2"
            title="test">
            <img class="h-full w-full object-cover rounded-md"
                src="/storage/resources/FzAuDUz2t7lIQaHXI2Te6T0LerLXODNKUXfVRKvp.png" alt="image"
                onerror="this.src='/images/berkas.svg'">
            <p class="text-xs mt-1"></p>
        </button>
    </template>
@endsection
@push('scripts')
    <script>
        var picCount = {{ old('resource') ? count(old('resource')) : $pengajuanproker->resources->count() }};
        async function loadresources() {
            if (!isTokenValid()) {
                await syncToken();
            }
            $('#popover-resource-container').html('<p class="text-gray-500">Loading...</p>');
            $.ajax({
                url: '{{ route('api.resources.index') }}',
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('sync_token'),
                },
                success: function(response) {
                    const container = $('#popover-resource-container');
                    container.empty();
                    response.data.forEach(resource => {
                        const template = document.querySelector('template');
                        const clone = template.content.cloneNode(true);
                        const newresource = $(clone).find(
                            '[data-template="popover-resource-item"]');
                        newresource.removeAttr('data-template');
                        newresource.find('img').attr('src',
                            /^image\/(jpeg|png|gif|bmp|webp|svg\+xml|x-icon|avif|tiff?)$/.test(
                                resource.type) ? resource.url : "test");
                        newresource.find('img').attr('alt', resource.alt_text);
                        newresource.find('p').text(resource.name.substr(0, 14) + (resource.name
                            .length > 14 ? '...' : ''));
                        newresource.attr('title', resource.name);
                        newresource.attr('onclick', `addThisresource(${JSON.stringify(resource)})`);
                        container.append(newresource);
                    });
                },
                error: function() {
                    $('#popover-resource-container').html(
                        '<p class="text-red-500">Failed to load resources.</p>');
                }
            })
        }

        function addThisresource(resource) {
            picCount++;
            const template = document.querySelector('template');
            const clone = template.content.cloneNode(true);
            const newresource = $(clone).find('[data-template="resource-card"]');
            newresource.removeAttr('data-template');
            newresource.find('img').attr('src', resource.url);
            newresource.find('img').attr('alt', resource.name);
            newresource.find('input[data-role="resource_id"]').val(resource.id);
            newresource.find('input[data-role="resource_id"]').attr('name', `resource[${picCount}][resource_id]`);
            newresource.find('input[data-role="resource_url"]').val(resource.url);
            newresource.find('input[data-role="resource_url"]').attr('name', `resource[${picCount}][url]`);
            newresource.find('button').attr('title', resource.name);
            newresource.find('button p').text(resource.name.substr(0, 14) + (resource.name.length > 14 ? '...' : ''));
            $('#add-resource-btn').before(newresource);

            $('#popover-add-resource')[0].hidePopover();
        }
        async function uploadresource(event) {
            event.preventDefault();
            if (!$('#file')[0].files[0] && !$('#fileurl').val()) {
                alert('Please select a file or enter a file URL.');
                return;
            }
            if (!isTokenValid()) {
                await syncToken();
            }
            const form = new FormData();
            if ($('#file')[0].files[0]) {
                form.append('file', $('#file')[0].files[0]);
            }
            if ($('#fileurl').val()) {
                form.append('fileurl', $('#fileurl').val());
            }
            $.ajax({
                url: "{{ route('api.resources.store') }}",
                type: "POST",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('sync_token'),
                },
                data: form,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('resource uploaded successfully!');
                    $('#file').val('');
                    $('#fileurl').val('');
                    loadresources();
                },
                error: function() {
                    alert('An error occurred while uploading the resource.');
                }
            })
        }

        function deleteresource(button) {
            const $this = $(button);
            $this.parent().remove();
        }
    </script>
    <script>
        onloads.push(() => {
            loadresources();
        });
    </script>
@endpush
