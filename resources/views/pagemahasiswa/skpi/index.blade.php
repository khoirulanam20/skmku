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
                            <li class="breadcrumb-item active" aria-current="page">Pendaftaran SKPI</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data Pendaftaran SKPI</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('pendaftaranskpi.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Peminatan</th>
                                    <th>Kegiatan</th>
                                    <th>Total Skors</th>
                                    <th>Status</th>
                                    @foreach ($pendaftaranSkpis as $index => $p)
                                    @if ($p->status !== 'diterima')
                                    <th>Aksi</th>
                                    @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftaranSkpis as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->peminatan }}</td>
                                        
                                        {{-- Display Skors Data --}}
                                        @php
                                            $skors = json_decode($p->skors, true);
                                            $totalSkor = 0; // Initialize total score
                                        @endphp
                                        <td>
                                            @if ($skors && is_array($skors))
                                                <ul>
                                                    @foreach ($skors as $skor)
                                                        <li>
                                                            <strong>Judul Kegiatan:</strong> {{ $skor['judul_kegiatan'] ?? 'N/A' }} <br>
                                                            <strong>Kategori:</strong> {{ $skor['nama_kategori'] ?? 'N/A' }} <br>
                                                            <strong>Unsur:</strong> {{ $skor['nama_unsur'] ?? 'N/A' }} <br>
                                                            <strong>Sub Unsur:</strong> {{ $skor['nama_sub_unsur'] ?? 'N/A' }} <br>
                                                            <strong>Tingkat:</strong> {{ $skor['nama_tingkat'] ?? 'N/A' }} <br>
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
                            
                                        {{-- Display Status --}}
                                        
                                        <td>
                                            @if ($p->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($p->status == 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                                <button type="button" class="btn-sm btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Lihat komentar</button>
                                            @elseif($p->status == 'diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown Status</span>
                                            @endif
                                        </td>
                            
                                        {{-- Aksi Column --}}
                                        @if ($p->status !== 'diterima')
                                        <td>
                                            <form action="{{ route('pendaftaranskpi.destroy', $p->id) }}" method="POST" style="display:inline;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                @if ($p->status !== 'diterima')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                @endif
                                            </form>
                                        </td>
                                        @endif
                            
                                        <td>
                                            @if ($p->dokumen_kegiatan)
                                                <a href="{{ asset('dokumen/dokumen_kegiatan/' . basename($p->dokumen_kegiatan)) }}" target="_blank">Dokumen Kegiatan</a><br>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            

                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Peminatan</th>
                                    <th>Kegiatan</th>
                                    <th>Total Skors</th>
                                    <th>Status</th>
                                    @foreach ($pendaftaranSkpis as $index => $p)
                                    @if ($p->status !== 'diterima')
                                    <th>Aksi</th>
                                    @endif
                                    @endforeach
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
                        @foreach ($pendaftaranSkpis as $index => $p)
                            <div class="modal-body">{{ $p->komentar }}</div>
                            <div class="modal-footer">
                               <span class="text-warning">*Silahkan input ulang!</span>
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
