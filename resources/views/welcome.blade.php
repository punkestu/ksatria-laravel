@extends('layouts.base')
@section('content')
    <main class="min-h-screen">
        <section id="hero" class="relative h-[calc(100vh-2.5rem-0.5rem)] flex items-center">
            <div class="p-8 lg:p-28 xl:max-w-[55vw] flex flex-col items-start gap-4" data-aos="fade-up">
                <h2 class="font-black text-4xl lg:text-7xl text-accent-1">Selamat Datang Agent of Change (Ksatria)</h2>
                <p class="lg:max-w-[65%] text-sm lg:text-base text-accent-2 ps-2">CHAMPION (change agent monitoring Platform for Internalization)
                    merupakan suatu platform yang digunakan oleh para Agent of Change (KSATRIA) untuk melaporkan progress
                    pelaksanaan internalisasi budaya perusahaan (corporate culture) di masing-masing lokasi.</p>
                <a class="px-8 py-2 rounded-full bg-accent-1 hover:bg-accent-1/75 duration-300 text-white"
                    href="{{ route('program-kerja') }}">Lihat Program Kerja</a>
            </div>
            <div class="-z-10 absolute right-0 h-full w-screen lg:ps-2 lg:w-2/3" data-aos="fade">
                <img class="object-cover h-full opacity-25 xl:opacity-75" src="/images/hero.png" alt="hero">
            </div>
        </section>
        <section id="akhlak" class="bg-accent-2 flex flex-col md:flex-row items-center gap-4 p-8 pe-0 overflow-hidden">
            <aside class="md:max-w-1/3" data-aos="fade-right">
                <h2 class="font-bold text-4xl text-white">
                    AKHLAK
                </h2>
                <p class="text-slate-200 mt-2">
                    merupakan nilai-nilai utama (core values) pengelolaan sumber daya manusia (SDM) di Badan Usaha Milik
                    Negara (BUMN) sesuai amanat dari Surat Edaran Menteri BUMN Nomor: SE-7/MBU/072020 tentang NILAI-NILAI
                    UTAMA (CORE VALUES) SUMBER DAYA MANUSIA BADAN USAHA MILIK NEGARA
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
        <section id="visimisi" class="flex flex-col md:flex-row justify-between p-8 md:p-16 gap-16" data-aos="fade-up">
            <aside class="flex flex-col gap-2 min-w-1/2">
                <h2 class="font-bold text-4xl">VISI</h2>
                <p class="text-left">
                    The trusted partner for the aviation community.
                </p>
            </aside>
            <aside class="flex flex-col gap-2 md:max-w-1/2">
                <h2 class="font-bold text-4xl">MISI</h2>
                <p class="text-left">
                    To ensure safe and seamless air navigation through our continuous collaborative commitment towards
                    constumer contricity, talent development, operations excellence, and technological advancement.
                </p>
            </aside>
        </section>
        <section id="video" class="p-8 md:p-16" data-aos="fade">
            <iframe class="w-full aspect-video" src="https://www.youtube.com/embed/mbkI7aKOkE0?si=WVKnIDGcgPHb8Bdi"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </section>
    </main>
@endsection
