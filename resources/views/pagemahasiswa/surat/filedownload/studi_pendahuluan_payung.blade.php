<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A1.2 SURAT STUDI PENDAHULUAN PAYUNG</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin-bottom: 100px;
            /* Untuk memastikan konten tidak menabrak footer */
        }

        /* Gaya untuk memastikan gambar di kiri dan teks di tengah */
        .header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 100%;
            margin-left: 50px;
            margin-right: 50px;
        }

        .header div {
            flex-grow: 1;
        }

        .header h3,
        .header p {
            margin: 0;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 0;
            font-size: 24px;
        }

        .infomhs p {
            margin: 0;
            font-size: 24px;
        }

        .info span {
            display: inline-block;
            width: 150px;
        }

        .infomhs span {
            display: inline-block;
            width: 300px;
        }

        .signature {
            position: relative;
            text-align: center;
            margin-top: 50px;
            margin-left: 500px;
        }

        .signature p {
            margin: 0;
        }

        .page-break {
            page-break-after: always;
        }

        /* CSS untuk memastikan footer selalu di bawah */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: white;
            padding: 10px 0;
        }

        .footer img {
            width: 1000px;
            height: auto;
        }

        .page-break {
            page-break-after: always;
            /* Ensures the content after this class starts on a new page */
        }
        .table-container {
            margin-bottom: 20px;
            /* Jarak bawah untuk tabel */
        }

        .table-container table {
            width: 100%;
            /* Memastikan tabel mengambil lebar penuh */
            border-collapse: collapse;
            /* Menghapus jarak antara border tabel */
        }

        .table-container th,
        .table-container td {
            border: 1px solid black;
            /* Border untuk sel tabel */
            padding: 8px;
            /* Jarak dalam sel */
            text-align: left;
            /* Teks rata kiri */
        }

        .table-container th {
            background-color: #f2f2f2;
            /* Warna latar belakang untuk header tabel */
        }
    </style>
</head>

<body>
    <div class="header">
        <img alt="University logo" src="{{ asset('env') }}/kopsurat.png" height="auto" width="1000px" />
    </div>

    <div class="container">
        <div class="info mb-5 mt-5">
            <p><span>No</span> : {{ $pendaftaransurat->no_surat }} </p>
            <p><span>Lamp</span> : --</p>
            <p><span>Hal</span> : <u><em>Survey Awal</em></u></p>
        </div>

        <div class="info mb-5 mt-5">
            <p>Kepada Yth</p>
            <p>{{ $pendaftaransurat->tujuan_surat }}</p>
            <p>di</p>
            <p>Tempat</p>
        </div>

        <div class="info mb-4 mt-4">
            <p>Dengan Hormat,</p>
        </div>

        <div class="info mb-4 mt-4">
            <p>Bersama ini kami hadapkan mahasiswa Program Studi S1 Kesehatan Masyarakat di lingkungan Fakultas
                Kesehatan (F.Kes) Universitas Dian Nuswantoro Semarang.</p>
        </div>

        <div class="infomhs mb-5 ml-5">
            <p><span>Program Studi</span> : S1 Kesehatan Masyarakat</p>
            <p><span>Waktu</span> : 1 Bulan</p>
        </div>

        <div class="info mb-4 mt-4" style="text-align: justify;">
            <p>Mohon diijinkan untuk mengambil data {{ $pendaftaransurat->data_diperlukan_jika_ditujukan_ke_dinkes }}
                guna keperluan skripsi {{ $pendaftaransurat->judul_skripsi }}</p>
        </div>

        <div class="info mb-4 mt-4" style="text-align: justify;">
            <p>Demikian permohonan kami, atas perkenan, perhatian dan kerjasamanya kami ucapkan terimakasih.</p>
        </div>
        <div class="signature info">
            <p>Semarang, {{ \Carbon\Carbon::parse($pendaftaransurat->created_at)->translatedFormat('d F Y') }}</p>
            <img alt="University logo" src="{{ asset('env') }}/ttdsurat.png" height="auto" width="400px" />
        </div>
    </div>

    <div class="footer">
        <img alt="footer" src="{{ asset('env') }}/footersurat.png" />
    </div>

    <div class="page-break"></div> <!-- Page break for the second page -->

    <div class="header">
        <img alt="University logo" src="{{ asset('env') }}/kopsurat.png" height="auto" width="1000px" />
    </div>

    <div class="container">
        <div class="info mb-5 mt-5">
            <p><span>No</span> : {{ $pendaftaransurat->no_surat }} </p>
            <p><span>Lamp</span> : --</p>
            <p><span>Hal</span> : <u><em>Survey Awal</em></u></p>
        </div>

        <div class="info mb-5 mt-5">
            <p><b>Nama Mahasiswa yang mengajukan surat</b></p>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaransurat->mahasiswa_payung as $index => $mahasiswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mahasiswa['nama'] }}</td>
                        <td>{{ $mahasiswa['nim'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

        <div class="signature info">
            <p>Semarang, {{ \Carbon\Carbon::parse($pendaftaransurat->created_at)->translatedFormat('d F Y') }}</p>
            <img alt="University logo" src="{{ asset('env') }}/ttdsurat.png" height="auto" width="400px" />
        </div>
    </div>

    <div class="footer">
        <img alt="footer" src="{{ asset('env') }}/footersurat.png" />
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    <script>
        const currentYear = new Date().getFullYear();
        const nextYear = currentYear + 1;
        document.getElementById('academic-year').innerText = `${currentYear} / ${nextYear}`;
    </script>
</body>

</html>
