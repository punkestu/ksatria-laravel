<h3>Program Kerja Champion AirNav</h3>
<h4>Data Program</h4>
<table style="width:100%">
    <tr>
        <th style="width:20%;padding-bottom:10px;padding-right:2px">Program</th>
        <td style="width:80%;padding-bottom:10px;padding-left:2px">: {{ $pengajuanproker->programKerja->name }}</td>
    </tr>
    <tr>
        <th style="width:20%;padding-bottom:10px;padding-right:2px">Cabang</th>
        <td style="width:80%;padding-bottom:10px;padding-left:2px">: {{ $pengajuanproker->cabang->name }}</td>
    </tr>
    <tr>
        <th style="width:20%;padding-bottom:10px;padding-right:2px">Nama</th>
        <td style="width:80%;padding-bottom:10px;padding-left:2px">: {{ $pengajuanproker->name }}</td>
    </tr>
    <tr>
        <th style="width:20%;padding-bottom:10px;padding-right:2px">Deskripsi</th>
        <td style="width:80%;padding-bottom:10px;padding-left:2px">: {{ $pengajuanproker->description }}</td>
    </tr>
    <tr>
        <th style="width:20%;padding-bottom:10px;padding-right:2px">Jangka Waktu</th>
        <td style="width:80%;padding-bottom:10px;padding-left:2px">: {{ $pengajuanproker->start_date }} -
            {{ $pengajuanproker->end_date }}</td>
    </tr>
</table>
@if ($pengajuanproker->status == 'completed')
    <h4>Pelaporan</h4>
    <p>Diselesaikan pada tanggal {{ $pengajuanproker->tgl_selesai }}.</p>
    <p>Keterangan:</p>
    <p>{{ $pengajuanproker->keterangan }}</p>

    <h4>Lampiran</h4>
    @foreach ($pengajuanproker->resources as $resource)
        <p>{{ $resource->name }}</p>
        @if (str_contains($resource->type, 'image'))
            <div style="width: 500px">
                <img style="width: 100%" src="{{ public_path($resource->url) }}" alt="Lampiran-{{ $loop->iteration }}">
            </div>
        @else
            <p>File tidak didukung untuk ditampilkan.</p>
        @endif
    @endforeach
@endif
