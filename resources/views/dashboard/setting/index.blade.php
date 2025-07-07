@extends('layouts.dashboard')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="sync-token-url" content="{{ route('api.auth.getSanctumToken') }}">
@endpush
@section('dashboard-content')
    <main>
        <section id="update-welcome-video">
            <h1 class="text-2xl font-semibold mb-4">Pengaturan</h1>
            <div class="bg-white p-4 rounded-md shadow">
                <form onsubmit="submitwelcomevideo(event)">
                    <div class="mb-4">
                        <label for="welcome_video" class="block font-medium text-gray-700">Video Selamat Datang</label>
                        <div class="my-2 h-48 flex justify-center items-center relative border rounded-md">
                            <p id="welcome_video_label">Upload video mp4 atau sejenis maksimal 20MB</p>
                            <input type="file" name="welcome_video" id="welcome_video"
                                class="h-full w-full z-10 absolute opacity-0" accept="video/mp4,video/x-m4v,video/*" onchange="onwelcomevideochange(this)">
                        </div>
                    </div>
                    <button type="submit" id="submit_welcome_video"
                        class="px-4 py-2 bg-accent-1 text-white rounded-md hover:bg-accent-2 transition duration-200">Simpan</button>
                </form>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        function onwelcomevideochange(el) {
            const file = el.files[0];
            if (file) {
                const fileSizeMB = file.size / (1024 * 1024);
                if (fileSizeMB > 20) {
                    alert('Ukuran file terlalu besar. Maksimal 20MB.');
                    el.value = ''; // Clear the input
                } else {
                    const label = document.getElementById('welcome_video_label');
                    label.textContent = file.name; // Update label with the file name   
                }
            }
        }

        async function submitwelcomevideo(event) {
            event.preventDefault(); // Prevent the default form submission
            const formData = new FormData();
            const welcomeVideoInput = document.getElementById('welcome_video');

            if (welcomeVideoInput.files.length === 0) {
                toast('error', 'Silakan pilih file video terlebih dahulu.');
                return;
            }

            // Check if the file is selected and is a valid video type
            if (!welcomeVideoInput.files[0].type.startsWith('video/')) {
                toast('error', 'File yang dipilih bukan video. Silakan pilih file video yang valid.');
                return;
            }

            // Check if the file size is within the limit
            if (welcomeVideoInput.files[0].size > 20 * 1024 * 1024) {
                toast('error', 'Ukuran file terlalu besar. Maksimal 20MB.');
                return;
            }

            formData.append('welcome_video', welcomeVideoInput.files[0]);

            $('#submit_welcome_video').disabled = true; // Disable the button to prevent multiple submissions
            $('#submit_welcome_video').text('Mengunggah...'); // Change button text to indicate upload in progress

            if (!isTokenValid()) {
                await syncToken();
            }

            $.ajax({
                url: '{{ route('api.welcome_video.update') }}',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('sync_token'),
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    toast('success', 'Video selamat datang berhasil diunggah.');
                    welcomeVideoInput.value = ''; // Clear the input
                    document.getElementById('welcome_video_label').textContent = 'Upload video mp4 atau sejenis maksimal 20MB';
                },
                error: function(xhr, status, error) {
                    toast('error', 'Gagal mengunggah video selamat datang. Silakan coba lagi.');
                },
                complete: function() {
                    $('#submit_welcome_video').disabled = false; // Re-enable the button
                    $('#submit_welcome_video').text('Simpan'); // Reset button text
                }
            });
        }
        onloads.push(function() {});
    </script>
@endpush
