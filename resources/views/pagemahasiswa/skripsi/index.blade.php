@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Forms</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pendaftaran Skripsi</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data Pendaftaran Skripsi</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('pendaftaranskripsi.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Skripsi</th>
                                    <th>Peminatan</th>
                                    <th>Dosen Pembimbing</th>
                                    <th>Dosen Ketua Penguji</th>
                                    <th>Dosen Penguji</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftaranSkripsis as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->judul_skripsi }}</td>
                                        <td>{{ $p->peminatan }}</td>
                                        <td>{{ $p->dosenpembimbing->nama }}</td>
                                        <td>{{ $p->dosenketuapenguji->nama }}</td>
                                        <td>{{ $p->dosenpenguji->nama }}</td>
                                        <td>
                                            @if ($p->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($p->status == 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                                <!-- modal komentar -->
                                                <button type="button" class="btn-sm btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">Lihat komentar</button>
                                                <!-- modal komentar -->
                                            @elseif($p->status == 'diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown Status</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->status === 'pending')
                                                <a href="{{ route('pendaftaranskripsi.edit', $p->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                            @endif
                                            <form action="{{ route('pendaftaranskripsi.destroy', $p->id) }}" method="POST"
                                                style="display:inline;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                @if ($p->status !== 'diterima')
                                                    {{-- Check if the status is not "diterima" --}}
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                @endif
                                            </form>

                                            {{-- FILE DOWNLOAD --}}
                                            @if ($p->status === 'diterima')
                                                {{-- Check if the status is "diterima" --}}
                                                <a href="{{ route('downloadskripsi.c1', $p->id) }}" target="_blank">C1. LAYOUT SKRIPSI</a><br>
                                                <a href="{{ route('downloadskripsi.c2', $p->id) }}" target="_blank">C2. FILE PERBAIKAN PENGUJI DAN PEMBIMBING</a><br>
                                                <a href="{{ asset('filedownload/TATA_TERTIB_UJIAN_SKRIPSI.pdf') }}"
                                                    target="_blank">TATA TERTIB UJIAN SKRIPSI</a>
                                            @endif
                                            {{-- FILE DOWNLOAD --}}


                                        </td>
                                        <td>
                                            @if ($p->file_persetujuan_pendaftaran_sidang_skripsi)
                                                <a href="{{ asset('dokumen/persetujuan_pendaftaran_sidang_skripsi/' . basename($p->file_persetujuan_pendaftaran_sidang_skripsi)) }}"
                                                    target="_blank">Persetujuan Pendaftaran Sidang Skripsi</a><br>
                                            @endif
                                            @if ($p->dokumen_pendaftaran_ujian_skripsi)
                                                <a href="{{ asset('dokumen/pendaftaran_ujian_skripsi/' . basename($p->dokumen_pendaftaran_ujian_skripsi)) }}"
                                                    target="_blank">Pendaftaran Ujian Skripsi</a><br>
                                            @endif
                                            @if ($p->kartu_bimbingan)
                                                <a href="{{ asset('dokumen/kartu_bimbingan/' . basename($p->kartu_bimbingan)) }}"
                                                    target="_blank">Kartu Bimbingan</a><br>
                                            @endif
                                            @if ($p->dokumen_kartu_rencana_studi)
                                                <a href="{{ asset('dokumen/kartu_rencana_studi/' . basename($p->dokumen_kartu_rencana_studi)) }}"
                                                    target="_blank">Kartu Rencana Studi</a><br>
                                            @endif
                                            @if ($p->dokumen_transkrip_nilai)
                                                <a href="{{ asset('dokumen/transkrip_nilai/' . basename($p->dokumen_transkrip_nilai)) }}"
                                                    target="_blank">Transkrip Nilai</a><br>
                                            @endif
                                            @if ($p->dokumen_bebas_biaya_administrasi)
                                                <a href="{{ asset('dokumen/bebas_biaya_administrasi/' . basename($p->dokumen_bebas_biaya_administrasi)) }}"
                                                    target="_blank">Bebas Biaya Administrasi</a><br>
                                            @endif
                                            @if ($p->dokumen_bebas_pinjaman_perpustakaan)
                                                <a href="{{ asset('dokumen/bebas_pinjaman_perpustakaan/' . basename($p->dokumen_bebas_pinjaman_perpustakaan)) }}"
                                                    target="_blank">Bebas Pinjaman Perpustakaan</a><br>
                                            @endif
                                            @if ($p->dokumen_ijazah_terakhir)
                                                <a href="{{ asset('dokumen/ijazah_terakhir/' . basename($p->dokumen_ijazah_terakhir)) }}"
                                                    target="_blank">Ijazah Terakhir</a><br>
                                            @endif
                                            @if ($p->dokumen_fotocopy_toefl)
                                                <a href="{{ asset('dokumen/fotocopy_toefl/' . basename($p->dokumen_fotocopy_toefl)) }}"
                                                    target="_blank">Fotocopy TOEFL</a><br>
                                            @endif
                                            @if ($p->dokumen_input_skpi)
                                                <a href="{{ asset('dokumen/input_skpi/' . basename($p->dokumen_input_skpi)) }}"
                                                    target="_blank">Input SKPI</a><br>
                                            @endif
                                            @if ($p->draft_skripsi)
                                                <a href="{{ asset('dokumen/draft_skripsi/' . basename($p->draft_skripsi)) }}"
                                                    target="_blank">Draft Skripsi</a><br>
                                            @endif
                                            @if ($p->dokumen_artikel_ilmiah)
                                                <a href="{{ asset('dokumen/artikel_ilmiah/' . basename($p->dokumen_artikel_ilmiah)) }}"
                                                    target="_blank">Artikel Ilmiah</a><br>
                                            @endif
                                            @if ($p->file_turnitin)
                                                <a href="{{ asset('dokumen/turnitin/' . basename($p->file_turnitin)) }}"
                                                    target="_blank">File Turnitin</a><br>
                                            @endif
                                            @if ($p->bukti_pendaftaran_siadin)
                                                <a href="{{ asset('dokumen/bukti_pendaftaran_siadin/' . basename($p->bukti_pendaftaran_siadin)) }}"
                                                    target="_blank">Bukti Pendaftaran SIADIN</a><br>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Skripsi</th>
                                    <th>Peminatan</th>
                                    <th>Dosen Pembimbing</th>
                                    <th>Dosen Ketua Penguji</th>
                                    <th>Dosen Penguji</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal komentar -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Komentar
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @foreach ($pendaftaranSkripsis as $index => $p)
                            <div class="modal-body">{{ $p->komentar }}</div>
                            <div class="modal-footer">
                                <a href="{{ route('pendaftaranskripsi.edit', $p->id) }}" class="btn btn-success">Revisi</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- modal komentar -->
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
