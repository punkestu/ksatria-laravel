@extends('layouts.base')
@section('content')
    <main
        class="bg-[url('/images/people-background.png')] bg-no-repeat bg-cover bg-center min-h-screen flex flex-col items-center justify-center gap-8 p-8">
        <h2 class="text-center font-black text-5xl text-accent-1" data-aos="fade-down">
            Program Kerja
        </h2>
        <section id="program-kerja" class="flex justify-center gap-4 flex-wrap" data-aos="fade-up">
            <a href="{{ route('pengajuanproker.index', ['tab' => 'KSATRIA BAIK']) }}" class="bg-white p-4 rounded-lg flex gap-4">
                <div class="w-36 h-44 bg-gray-500 rounded-md">
                    <img class="object-cover object-top w-full h-full scale-100 hover:scale-125 duration-500" src="/images/program-kerja/KSATRIA BAIK.png" alt="Ksatria Baik">
                </div>
                <aside class="w-52 flex flex-col">
                    <h3 class="text-2xl font-bold">KSATRIA BAIK</h3>
                    <p class="text-sm italic">Berbagi Aksi, Ilmu dan Kepedulian</p>
                    <p class="text-xs pt-2">Mengusung konsep “sharing is caring”. Budaya untuk saling berbagi, baik yang
                        bersifat informasi,
                        knowledge maupun charity kepada lingkungan kerja atau lingkungan sekitar</p>
                </aside>
            </a>
            <a href="{{ route('pengajuanproker.index', ['tab' => 'KSATRIA SALAM']) }}" class="bg-white p-4 rounded-lg flex gap-4">
                <div class="w-36 h-44 bg-gray-500 rounded-md">
                    <img class="object-cover object-top w-full h-full scale-100 hover:scale-125 duration-500" src="/images/program-kerja/KSATRIA SALAM.png" alt="Ksatria Salam">
                </div>
                <aside class="w-52 flex flex-col">
                    <h3 class="text-2xl font-bold">KSATRIA SALAM</h3>
                    <p class="text-sm italic">Sinergi Antar Lintas Unit dan Stakeholder</p>
                    <p class="text-xs pt-2">Budaya untuk saling berdiskusi, sosialisasi dan bertukar pikiran dengan unit
                        kerja lain, organisasi profesi, serikat pekerja, para role model maupun instansi lain.</p>
                </aside>
            </a>
            <a href="{{ route('pengajuanproker.index', ['tab' => 'KSATRIA PINTAR']) }}" class="bg-white p-4 rounded-lg flex gap-4">
                <div class="w-36 h-44 bg-gray-500 rounded-md">
                    <img class="object-cover object-top w-full h-full scale-100 hover:scale-125 duration-500" src="/images/program-kerja/KSATRIA PINTAR.png" alt="Ksatria Pintar">
                </div>
                <aside class="w-52 flex flex-col">
                    <h3 class="text-2xl font-bold">KSATRIA PINTAR</h3>
                    <p class="text-sm italic">-</p>
                    <p class="text-xs pt-2">Budaya pembelajaran (learning culture) di tempat kerja yang bertujuan
                        menciptakan lingkungan yang mendukung pengembangan kompetensi, inovasi dan peningkatan kualitas
                        karyawan secara berkelanjutan
                    </p>
                </aside>
            </a>
            <a href="{{ route('pengajuanproker.index', ['tab' => 'KSATRIA RESIK']) }}" class="bg-white p-4 rounded-lg flex gap-4">
                <div class="w-36 h-44 bg-gray-500 rounded-md">
                    <img class="object-cover object-top w-full h-full scale-100 hover:scale-125 duration-500" src="/images/program-kerja/KSATRIA RESIK.png" alt="Ksatria Resik">
                </div>
                <aside class="w-52 flex flex-col">
                    <h3 class="text-2xl font-bold">
                        KSATRIA RESIK</h3>
                    <p class="text-sm italic">-</p>
                    <p class="text-xs pt-2">
                        Budaya senang bersih- bersih dan merapihkan ruang kerja yg bertujuan menciptakan lingkungan kerja
                        nyaman, rapi,
                        dan sehat sehingga meningkatkan produktifitas serta semangat karyawan.</p>
                </aside>
            </a>
            <a href="{{ route('pengajuanproker.index', ['tab' => 'KSATRIA BISA']) }}" class="bg-white p-4 rounded-lg flex gap-4">
                <div class="w-36 h-44 bg-gray-500 rounded-md">
                    <img class="object-cover object-top w-full h-full scale-100 hover:scale-125 duration-500" src="/images/program-kerja/KSATRIA BISA.png" alt="Ksatria Bisa">
                </div>
                <aside class="w-52 flex flex-col">
                    <h3 class="text-2xl font-bold">
                        KSATRIA BISA</h3>
                    <p class="text-sm italic">
                        Belajar Inovatif Secara Aktif</p>
                    <p class="text-xs pt-2">
                        Budaya untuk terus mendorong karyawan ditempat kerja agar memiliki inovasi. Inovasi dapat berupa
                        sistem
                        digitalisasi dalam proses kerja di masing masing unit ataupun perubahan alur dan prosedur kerja.</p>
                </aside>
            </a>
            <a href="{{ route('pengajuanproker.index', ['tab' => 'KSATRIA SEHAT']) }}" class="bg-white p-4 rounded-lg flex gap-4">
                <div class="w-36 h-44 bg-gray-500 rounded-md">
                    <img class="object-cover object-top w-full h-full scale-100 hover:scale-125 duration-500" src="/images/program-kerja/KSATRIA SEHAT.png" alt="Ksatria Sehat">
                </div>
                <aside class="w-52 flex flex-col">
                    <h3 class="text-2xl font-bold">
                        KSATRIA SEHAT</h3>
                    <p class="text-sm italic">-</p>
                    <p class="text-xs pt-2">
                        Budaya untuk menjalani hidup sehat dan selain itu, didalam program ini KSATRIA juga diminta untuk
                        mencari
                        talenta-talenta terbaik dibidang olahraga yang ada di AirNav Indonesia</p>
                </aside>
            </a>
            <a href="{{ route('pengajuanproker.index', ['tab' => 'KSATRIA S.H.A.R.E']) }}" class="bg-white p-4 rounded-lg flex gap-4">
                <div class="w-36 h-44 bg-gray-500 rounded-md">
                    <img class="object-cover object-top w-full h-full scale-100 hover:scale-125 duration-500" src="/images/program-kerja/KSATRIA SHARE.png" alt="Ksatria Share">
                </div>
                <aside class="w-52 flex flex-col">
                    <h3 class="text-2xl font-bold">
                        KSATRIA S.H.A.R.E</h3>
                    <p class="text-sm italic">-</p>
                    <p class="text-xs pt-2">
                        KSATRIA didorong untuk membuat publikasi (Mading, Quote, PoV, Campaign, Poster dan media komunikasi
                        lainnya) di
                        lingkungan kerja terkait budaya perusahaan (AKHLAK) dan budaya keselamatan</p>
                </aside>
            </a>
            <a href="{{ route('pengajuanproker.index', ['tab' => 'KSATRIA RELIGI']) }}" class="bg-white p-4 rounded-lg flex gap-4">
                <div class="w-36 h-44 bg-gray-500 rounded-md">
                    <img class="object-cover object-top w-full h-full scale-100 hover:scale-125 duration-500" src="/images/program-kerja/ksatria-religi.jpeg" alt="Ksatria Religi">
                </div>
                <aside class="w-52 flex flex-col">
                    <h3 class="text-2xl font-bold">
                        KSATRIA RELIGI</h3>
                    <p class="text-sm italic">-</p>
                    <p class="text-xs pt-2">
                        Budaya untuk meningkatkan spiritualitas (Spiritual development) di tempat kerja bagi setiap karyawan
                        dan
                        karyawati dengan berbagai cara yang positif dan inklusif</p>
                </aside>
            </a>
        </section>
    </main>
@endsection
