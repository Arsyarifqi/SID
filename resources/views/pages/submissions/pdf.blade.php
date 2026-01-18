<!DOCTYPE html>
<html>
<head>
    <title>Cetak Surat</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; }
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 5px; margin-bottom: 20px; text-align: center; }
        .kop-surat h2, .kop-surat h3 { margin: 0; text-transform: uppercase; }
        .isi-surat { margin: 0 40px; }
        .nomor-surat { text-align: center; margin-bottom: 20px; text-decoration: underline; font-weight: bold; }
        .identitas { margin-left: 30px; margin-bottom: 20px; }
        .ttd { float: right; width: 200px; margin-top: 40px; text-align: center; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h3>PEMERINTAH KABUPATEN MOJOKERTO</h3>
        <h3>KECAMATAN PACET</h3>
        <h2>KANTOR KEPALA DESA SIDESA</h2>
        <small>Jl. Raya Desa No. 01 Telp: (0321) 123456 Kode Pos 61354</small>
    </div>

    <div class="isi-surat">
        <div class="nomor-surat">
            {{ strtoupper($sub->type) }}<br>
            <small>Nomor: 140 / {{ $sub->id }} / 417.312.7 / {{ date('Y') }}</small>
        </div>

        <p>Yang bertanda tangan di bawah ini, Kepala Desa SIDESA menerangkan bahwa:</p>
        
        <table class="identitas">
            <tr><td>Nama</td><td>:</td><td><strong>{{ $sub->resident->name }}</strong></td></tr>
            <tr><td>NIK</td><td>:</td><td>{{ $sub->resident->nik }}</td></tr>
            <tr><td>Tempat, Tgl Lahir</td><td>:</td><td>{{ $sub->resident->birth_place }}, {{ $sub->resident->birth_date }}</td></tr>
            <tr><td>Alamat</td><td>:</td><td>RT {{ $sub->resident->rtUnit->number }} / RW {{ $sub->resident->rwUnit->number }}</td></tr>
        </table>

        <p>Benar nama tersebut di atas adalah warga kami yang berdomisili di Desa SIDESA. Surat ini dibuat untuk keperluan: <strong>{{ $sub->necessity }}</strong>.</p>

        <p>Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>

        <div class="ttd">
            Mojokerto, {{ date('d F Y') }}<br>
            Kepala Desa SIDESA,
            <br><br><br><br>
            <strong>( ............................ )</strong>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>