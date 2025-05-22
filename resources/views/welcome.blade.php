<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Champion</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <header class="sticky top-0 flex items-center flex-wrap justify-between bg-accent-1 px-4 py-2 text-white z-30">
        <aside class="flex grow xl:grow-0 gap-4 items-center">
            <img class="h-8" src="/images/bumn.svg" alt="BUMN">
            <img class="h-10" src="/images/akhlak.png" alt="akhlak">
            <img class="h-10" src="/images/airnav.png" alt="Airnav">
            <h1 class="font-black text-lg">CHAMPION</h1>
        </aside>
        <button id="nav-opener" class="block xl:hidden rotate-0 duration-300">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 9-7 7-7-7" />
            </svg>
        </button>
        <nav class="hidden xl:flex items-center justify-end gap-8 grow">
            <a class="hover:text-white/75 duration-300 hover:underline" href="">Profil</a>
            <a class="hover:text-white/75 duration-300 hover:underline" href="">Program Kerja</a>
            <a class="hover:text-white/75 duration-300 hover:underline" href="">Statistik</a>
            <a class="hover:text-white/75 duration-300 hover:underline" href="">Struktur Organisasi</a>
            <a class="hover:text-white/75 duration-300 hover:underline" href="">Bantuan</a>
            <a class="hover:text-white/75 duration-300" href="">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z" />
                </svg>
            </a>
            <a class="bg-white hover:bg-white/75 duration-300 text-accent-1 px-8 py-1 rounded-full"
                href="">Login</a>
        </nav>
    </header>
    <nav id="nav-slide"
        class="w-screen flex flex-col fixed -top-full items-center justify-end grow bg-white z-10 p-4 pt-0 transition-all duration-500 ease-in-out">
        <a class="hover:text-white/75 duration-300 py-2 border-b w-full text-center" href="">Profil</a>
        <a class="hover:text-white/75 duration-300 py-2 border-b w-full text-center" href="">Program Kerja</a>
        <a class="hover:text-white/75 duration-300 py-2 border-b w-full text-center" href="">Statistik</a>
        <a class="hover:text-white/75 duration-300 py-2 border-b w-full text-center" href="">Struktur
            Organisasi</a>
        <a class="hover:text-white/75 duration-300 py-2 border-b w-full text-center" href="">Bantuan</a>
        <a class="hover:text-white/75 duration-300 py-2 border-b w-full flex justify-center" href="">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z" />
            </svg>
        </a>
        <a class="mt-2 bg-accent-1 hover:bg-accent-1/75 duration-300 text-white px-8 py-1 rounded-full"
            href="">Login</a>
    </nav>
    <main class="min-h-screen">
        <section id="hero" class="relative h-[calc(100vh-2.5rem-0.5rem)] flex items-center">
            <div class="p-8 lg:p-28 xl:max-w-[55vw] flex flex-col items-start gap-4" data-aos="fade-up">
                <h2 class="font-black text-7xl text-accent-1">Selamat Datang Ksatria</h2>
                <p class="lg:max-w-[60%] text-accent-2 ps-2">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Exercitationem magnam itaque sit magni asperiores labore</p>
                <a class="px-8 py-2 rounded-full bg-accent-1 hover:bg-accent-1/75 duration-300 text-white"
                    href="">Lihat Program Kerja</a>
            </div>
            <div class="-z-10 absolute right-0 h-full w-screen lg:ps-2 lg:w-2/3" data-aos="fade">
                <img class="object-cover h-full opacity-25 xl:opacity-75" src="/images/hero.png" alt="hero">
            </div>
        </section>
        <section id="akhlak"
            class="bg-accent-2 flex flex-col md:flex-row items-center gap-4 p-8 pe-0 overflow-hidden">
            <aside data-aos="fade-right">
                <h2 class="font-bold text-4xl text-white">
                    AKHLAK
                </h2>
                <p class="text-slate-200 mt-2">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Nisl tincidunt eget nullam non.
                </p>
            </aside>
            <aside class="w-screen md:w-auto overflow-x-scroll scrollbar-hidden" data-aos="fade-left">
                <div class="flex gap-8 p-8">
                    <div class="p-4 rounded-lg bg-white">
                        <div class="flex">
                            <div class="h-36 w-28 relative">
                                <img class="absolute scale-[130%] origin-bottom-right" src="/images/akhlak/a1.png"
                                    alt="a">
                            </div>
                            <div class="w-48">
                                <h3 class="bg-accent-1 text-white text-center rounded-lg px-2 py-1">AMANAH</h3>
                                <p class="text-sm px-2 mt-2">Memegang Teguh Kepercayaan yang Diberikan</p>
                            </div>
                        </div>
                        <ul class="list-disc ps-5 text-sm">
                            <li>
                                Memenuhi janji dan komitmen
                            </li>
                            <li>
                                Bertanggung jawab atas tugas, keputusan dan tindakan yang dilakukan
                            </li>
                            <li>
                                Berpegang teguh kepada nilai moral dan etika
                            </li>
                        </ul>
                    </div>
                    <div class="p-4 rounded-lg bg-white">
                        <div class="flex">
                            <div class="h-36 w-28 relative">
                                <img class="absolute scale-[130%] origin-bottom-right" src="/images/akhlak/k1.png"
                                    alt="k">
                            </div>
                            <div class="w-48">
                                <h3 class="bg-accent-1 text-white text-center rounded-lg px-2 py-1">KOMPETEN</h3>
                                <p class="text-sm px-2 mt-2">Terus Belajar dan Mengembangkan Kapabilitas</p>
                            </div>
                        </div>
                        <ul class="list-disc ps-5 text-sm">
                            <li>
                                Memberi kesempatan kepada berbagai pihak yang berkontribusi
                            </li>
                            <li>
                                Terbuka dalam bekerja sama untuk menghasilkan nilai tambah
                            </li>
                            <li>
                                Menggerrakkan pemanfaatan berbagai sumber daya untuk tujuan bersama
                            </li>
                        </ul>
                    </div>
                    <div class="p-4 rounded-lg bg-white">
                        <div class="flex">
                            <div class="h-36 w-28 relative">
                                <img class="absolute scale-[130%] origin-bottom-right" src="/images/akhlak/h.png"
                                    alt="h">
                            </div>
                            <div class="w-48">
                                <h3 class="bg-accent-1 text-white text-center rounded-lg px-2 py-1">HARMONIS</h3>
                                <p class="text-sm px-2 mt-2">Saling Peduli dan Menghargai Perbedaan</p>
                            </div>
                        </div>
                        <ul class="list-disc ps-5 text-sm">
                            <li>
                                Menghargai setiap orang ataupun latar belakangnya
                            </li>
                            <li>
                                Suka menolong orang lain
                            </li>
                            <li>
                                Membangun lingkungan kerja yang kondusif
                            </li>
                        </ul>
                    </div>
                    <div class="p-4 rounded-lg bg-white">
                        <div class="flex">
                            <div class="h-36 w-28 relative">
                                <img class="absolute scale-[130%] origin-bottom-right" src="/images/akhlak/l.png"
                                    alt="l">
                            </div>
                            <div class="w-48">
                                <h3 class="bg-accent-1 text-white text-center rounded-lg px-2 py-1">LOYAL</h3>
                                <p class="text-sm px-2 mt-2">Berdedikasi dan Mengutamakan Kepentingan Bangsa dan Negara
                                </p>
                            </div>
                        </div>
                        <ul class="list-disc ps-5 text-sm">
                            <li>
                                Menjaga nama baik sesama karyawan, pimpinan, BUMN, dan Negara
                            </li>
                            <li>
                                Rela berkorban untuk mencapai tujuan yang lebih besar
                            </li>
                            <li>
                                Patuh pada pimpinan sepanjang tidak bertentangan dengan hukum dan etika
                            </li>
                        </ul>
                    </div>
                    <div class="p-4 rounded-lg bg-white">
                        <div class="flex">
                            <div class="h-36 w-28 relative">
                                <img class="absolute scale-[130%] origin-bottom-right" src="/images/akhlak/a2.png"
                                    alt="a2">
                            </div>
                            <div class="w-48">
                                <h3 class="bg-accent-1 text-white text-center rounded-lg px-2 py-1">ADAPTIF</h3>
                                <p class="text-sm px-2 mt-2">Terus Berinovasi dan Antusias dalam Menggerakkan ataupun
                                    Menghadapi Perubahan</p>
                            </div>
                        </div>
                        <ul class="list-disc ps-5 text-sm">
                            <li>
                                Cepat menyesuaikan diri untuk menjadi lebih baik
                            </li>
                            <li>
                                Terus menerus melakukan perbaikan mengikuti perkembangan teknologi
                            </li>
                            <li>
                                Bertindak proaktif
                            </li>
                        </ul>
                    </div>
                    <div class="p-4 rounded-lg bg-white">
                        <div class="flex">
                            <div class="h-36 w-28 relative">
                                <img class="absolute scale-[130%] origin-bottom-right" src="/images/akhlak/k2.png"
                                    alt="k2">
                            </div>
                            <div class="w-48">
                                <h3 class="bg-accent-1 text-white text-center rounded-lg px-2 py-1">KOLABORATIF</h3>
                                <p class="text-sm px-2 mt-2">Membangun Kerjasama yang Sinergis</p>
                            </div>
                        </div>
                        <ul class="list-disc ps-5 text-sm">
                            <li>
                                Meningkatkan kompetensi diri untuk menjawab tantangan yang selalu berubah
                            </li>
                            <li>
                                Membantu orang lain belajar
                            </li>
                            <li>
                                Menyelesaikan tugas dengan kualitas terbaik
                            </li>
                        </ul>
                    </div>

                </div>
            </aside>
        </section>
        <section id="visimisi" class="flex flex-col md:flex-row justify-between p-8 md:p-16 gap-16"
            data-aos="fade-up">
            <aside class="flex flex-col gap-2">
                <h2 class="font-bold text-4xl">VISI</h2>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Nisl tincidunt eget nullam non.
                </p>
            </aside>
            <aside class="flex flex-col gap-2">
                <h2 class="font-bold text-4xl">MISI</h2>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Nisl tincidunt eget nullam non.
                </p>
                <hr>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Nisl tincidunt eget nullam non.
                </p>
                <hr>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Nisl tincidunt eget nullam non.
                </p>
                <hr>
            </aside>
        </section>
        <section id="video" class="p-8 md:p-16" data-aos="fade">
            <iframe class="w-full" width="560" height="315"
                src="https://www.youtube.com/embed/mbkI7aKOkE0?si=WVKnIDGcgPHb8Bdi" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </section>
    </main>
    <footer class="-z-20 relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4 bg-accent-1 text-white">
        <img class="-z-10 opacity-10 md:opacity-65 absolute h-full right-0 bottom-0" src="/images/bumn-pattern.svg"
            alt="bumn-pattern">
        <aside class="z-0 flex flex-col items-center gap-2">
            <h2 class="font-bold">KONTAK</h2>
            <p class="text-slate-200 text-center md:text-left">
                Jl. Adi Sucipto No.KM.12, Pinang Kencana, Kec. Tanjungpinang Tim., Kota Tanjung Pinang, Kepulauan Riau
                29125 <br>
                Telp: 0771-7335581 <br>
                Email: airnavtnj@gmail.com
            </p>
        </aside>
        <aside class="z-0 flex flex-col items-center gap-2">
            <h2 class="font-bold">LAYANAN</h2>
            <div class="flex gap-4 text-slate-200">
                <aside>
                    <ul class="list-disc ps-4">
                        <li>Beranda</li>
                        <li>Profil</li>
                        <li>Program Kerja</li>
                    </ul>
                </aside>
                <aside>
                    <ul class="list-disc ps-4">
                        <li>Statistik</li>
                        <li>Struktur Organisasi</li>
                        <li>Bantuan</li>
                    </ul>
                </aside>
            </div>
        </aside>
        <h1 class="col-span-1 md:col-span-2 lg:col-span-1 z-0 self-center text-center text-5xl font-black">CHAMPION
        </h1>
    </footer>

    <script>
        window.addEventListener('load', () => {
            AOS.refresh();
            $("#nav-opener").click(() => {
                $("#nav-slide").toggleClass("-top-full top-14");
                $("#nav-opener").toggleClass("rotate-180 rotate-0");
            });
            // scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>

</html>
