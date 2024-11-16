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
                                    <a href="{{ route('exportskpi.index') }}" class="btn btn-success mb-3"><i class='bx bxs-file-export ' ></i> EXPORT EXCEL</a>

                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM Mahasiswa</th>
                                    <th>Peminatan</th>
                                    <th>Kegiatan</th>
                                    <th>Total Skors</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($PendaftaranSkpis as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->mahasiswa->nama }}</td>
                                        <td>{{ $p->mahasiswa->nim }}</td>
                                        <td>{{ $p->peminatan }}</td>
                                        @php
                                            // Decode the JSON string into an array
                                            $skors = json_decode($p->skors, true);
                                            $totalSkor = 0; // Initialize total score
                                        @endphp

                                        <td>
                                            @if ($skors && is_array($skors))
                                                <ul>
                                                    @foreach ($skors as $skor)
                                                        <li>
                                                            <strong>Judul Kegiatan:</strong> {{ $skor['judul_kegiatan'] ?? 'N/A' }}
                                                            <br>
                                                            <strong>Kategori:</strong> {{ $skor['nama_kategori'] ?? 'N/A' }}
                                                            <br>
                                                            <strong>Unsur:</strong> {{ $skor['nama_unsur'] ?? 'N/A' }} <br>
                                                            <strong>Sub Unsur:</strong>
                                                            {{ $skor['nama_sub_unsur'] ?? 'N/A' }} <br>
                                                            <strong>Tingkat:</strong> {{ $skor['nama_tingkat'] ?? 'N/A' }}
                                                            <br>
                                                            <strong>Skor:</strong> {{ $skor['skor'] ?? 'N/A' }}
                                                            @php $totalSkor += $skor['skor'] ?? 0; @endphp <!-- Add score to total -->
                                                        </li>
                                                        <hr>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p>No Skors Data Available</p>
                                            @endif
                                        </td>
                                            {{-- Display Total Score --}}
                                            <td class="text-center"><h1>{{ $totalSkor }}</h1></td> <!-- Total Skors Column -->

                                        <td>
                                            @if ($p->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($p->status == 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($p->status == 'diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown Status</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('verifskpi.detail', $p->id) }}"
                                                class="btn btn-sm btn-warning">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM Mahasiswa</th>
                                    <th>Peminatan</th>
                                    <th>Kegiatan</th>
                                    <th>Total Skors</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
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
