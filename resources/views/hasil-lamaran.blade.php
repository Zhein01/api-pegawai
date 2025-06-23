<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Seleksi Lamaran</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12pt;
            margin: 50px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 20pt;
            margin: 0;
        }
        .header p {
            margin: 0;
            font-size: 12pt;
        }
        .content {
            margin-top: 30px;
            line-height: 1.6;
        }
        .content p {
            margin: 8px 0;
        }
        .footer {
            margin-top: 60px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HASIL SELEKSI LAMARAN</h1>
        <p>PT Contoh Perusahaan</p>
    </div>

    <div class="content">
        <p>Kepada Yth:</p>
        <p><strong>{{ $nama }}</strong></p>
        <p>Email: {{ $email }}</p>
        <p>Telepon: {{ $telepon }}</p>
        <p>Pendidikan: {{ $pendidikan }}</p>

        <p>Dengan hormat,</p>
        <p>
            Berdasarkan hasil seleksi yang telah dilakukan, kami sampaikan bahwa Anda memperoleh skor sebesar <strong>{{ $skor }}</strong> dan dinyatakan <strong>{{ strtoupper($status) }}</strong>.
        </p>

        @if(strtolower($status) === 'lulus')
            <p>Selamat! Anda dinyatakan <strong>LULUS</strong> dalam proses seleksi ini. Informasi selanjutnya akan kami sampaikan melalui email.</p>
        @else
            <p>Kami mohon maaf, Anda <strong>TIDAK LULUS</strong> dalam proses seleksi kali ini. Terima kasih atas partisipasinya.</p>
        @endif

        <p>Demikian informasi ini kami sampaikan. Terima kasih atas perhatian Anda.</p>
    </div>

    <div class="footer">
        <p>Hormat kami,</p>
        <br><br>
        <p><strong>Tim Rekrutmen</strong></p>
    </div>
</body>
</html>
