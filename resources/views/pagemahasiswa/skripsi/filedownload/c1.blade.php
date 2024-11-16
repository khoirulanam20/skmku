<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C1. LAYOUT SKRIPSI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            font-family: 'Times New Roman', Times, serif;
            height: 100%;
        }

        /* Inner content border */
        .border-wrapper {
            border: 3px solid black;
            padding: 20px;
        }

        .border-table {
            border: 1px solid black;
        }

       

        .header-text {
            text-align: center;
            font-weight: bold;
        }

        .logo {
            text-align: center;
            margin: 20px 0;
        }

        .table-bordered td {
            border: 1px solid black;
        }

      
          
        
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h5 class="text-center fw-bold">SKRIPSI</h5>
            <h5 class="text-center fw-bold">PROGRAM STUDI SARJANA KESEHATAN MASYARAKAT</h5>
            <h5 id="academic-year" class="text-center fw-bold"></h5>

          
            
            <div class="logo">
                <img src="{{ asset('env') }}/udinus.png" alt="Logo" width="150">
            </div>

            <table class="table">
                <table class="table">
                    <tr>
                        <td style="width: 200px;">Nama</td>
                        <td style="width: 20px;">:</td>
                        <td class="">{{ $mahasiswa->nama }}</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">NIM</td>
                        <td style="width: 20px;">:</td>
                        <td class="">{{ $mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Judul Skripsi</td>
                        <td style="width: 20px;">:</td>
                        <td class="">{{ $pendaftaranskripsi->judul_skripsi }}</td>
                    </tr>
                </table>
                
            </table>

            <h5 class="text-center fw-bold">PELAKSANAAN</h5>

            <table class="table">
                <tr>
                    <td style="width: 200px;">Tanggal</td>
                    <td style="width: 20px;">:</td>
                    <td class="">{{ $pendaftaranskripsi->tanggal }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Jam</td>
                    <td style="width: 20px;">:</td>
                    <td class="">{{ $pendaftaranskripsi->waktu }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Lokasi</td>
                    <td style="width: 20px;">:</td>
                    <td class="">{{ $pendaftaranskripsi->tempat }}</td>
                </tr>
            </table>

            <table class="table table-bordered text-center">
                <tr>
                    <td class="fw-bold">KETUA PENGUJI</td>
                    <td class="fw-bold">PENGUJI</td>
                    <td class="fw-bold">PEMBIMBING</td>
                </tr>
                <tr>

                    <td class="">{{ $pendaftaranskripsi->dosenketuapenguji->nama }}</td>
                    <td class="">{{ $pendaftaranskripsi->dosenpenguji->nama }}</td>
                    <td class="">{{ $pendaftaranskripsi->dosenpembimbing->nama }}</td>
                </tr>
            </table>

            <h6 class="text-center mt-4 fw-bold">
                PROGRAM STUDI SARJANA KESEHATAN MASYARAKAT <br>
                FAKULTAS KESEHATAN <br>
                UNIVERSITAS DIAN NUSWANTORO SEMARANG
            </h6>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Trigger print dialog on page load -->
<script>
    window.onload = function () {
        window.print();
    }
</script>
<script>
    // Get the current year
    const currentYear = new Date().getFullYear();
    // Set the next year
    const nextYear = currentYear + 1;
    
    // Display the academic year in the desired format
    document.getElementById('academic-year').innerText = `TAHUN AKADEMIK ${currentYear} / ${nextYear}`;
</script>
</body>
</html>
