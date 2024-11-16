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
                            <li class="breadcrumb-item active" aria-current="page">Detail Pendaftaran Surat</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->

            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <hr />
                    <div class="card border-primary border-4">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center mb-4">
                                <div><i class="bx bxs-user me-2 font-22 text-primary"></i></div>
                                <h5 class="mb-0 text-primary">Detail Pendaftaran Surat</h5>
                            </div>
                            <hr />
                            <form action="{{ route('verifsurat.update', $pendaftaransurat->id) }}" method="POST"
                                enctype="multipart/form-data" class="row g-4">
                                @csrf
                                @method('PUT')

                                <!-- Mahasiswa Details -->
                                <div class="col-md-6">
                                    <label for="nama" class="form-label">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $pendaftaransurat->mahasiswa->nama }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim"
                                        value="{{ $pendaftaransurat->mahasiswa->nim }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control" id="telepon" name="telepon"
                                        value="{{ $pendaftaransurat->mahasiswa->telepon }}" readonly>
                                </div>

                                <!-- Proposal Details -->
                                <div class="col-md-6">
                                    <label for="judul_skripsi" class="form-label">Judul Skripsi</label>
                                    <input type="text" class="form-control" id="judul_skripsi" name="judul_skripsi"
                                        value="{{ $pendaftaransurat->judul_skripsi }}" readonly>
                                </div>

                                <!-- Surat Details -->
                                <div class="col-md-12">
                                    <label for="tujuan_surat" class="form-label">Tujuan Surat</label>
                                    <input type="text" class="form-control" value="{{ $pendaftaransurat->tujuan_surat }}"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="surat" class="form-label">Surat</label>
                                    <input type="text" class="form-control bg-success text-white"
                                        value="{{ $pendaftaransurat->surat }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="sub_surat" class="form-label">Sub Surat</label>
                                    <input type="text" class="form-control  bg-warning text-white"
                                        value="{{ $pendaftaransurat->sub_surat }}" readonly>
                                </div>



                                <!-- Document Links -->
                                @if ($pendaftaransurat->surat == 'Surat Penelitian')
                                    <div class="col-12">
                                        <h6 class="text-primary">Dokumen Pendukung</h6>
                                        <hr />
                                    </div>

                                    <div class="col-md-6">
                                        <label for="berita_acara" class="form-label">Berita Acara</label>
                                        <a href="{{ asset('dokumen/berita_acara/' . basename($pendaftaransurat->berita_acara)) }}"
                                            target="_blank" class="d-block">Lihat Berita Acara</a>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="ethical_clearance" class="form-label">Ethical Clearance</label>
                                        <a href="{{ asset('dokumen/ethical_clearance/' . basename($pendaftaransurat->ethical_clearance)) }}"
                                            target="_blank" class="d-block">Lihat Ethical Clearance</a>
                                    </div>
                                @endif
                                <!-- Document Links -->
                                @if ($pendaftaransurat->sub_surat == 'Payung')
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example2" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                <th>NIM</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($pendaftaransurat->mahasiswa_payung as $index => $mahasiswa)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $mahasiswa['nama'] }}</td>
                                                                    <td>{{ $mahasiswa['nim'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                <th>NIM</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif





                                <div class="col-12">
                                    <h6 class="text-primary">Verification</h6>
                                    <hr />
                                </div>

                                <div class="col-md-12 text-center">
                                    <!-- First Radio Button (Diterima) -->
                                    <input type="radio" class="btn-check" name="status" id="success-outlined"
                                        value="diterima" autocomplete="off"
                                        {{ $pendaftaransurat->status == 'diterima' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success me-3" for="success-outlined">Diterima</label>

                                    <!-- Second Radio Button (Ditolak) -->
                                    <input type="radio" class="btn-check" name="status" id="danger-outlined"
                                        value="ditolak" autocomplete="off"
                                        {{ $pendaftaransurat->status == 'ditolak' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-danger" for="danger-outlined">Ditolak</label>
                                </div>

                                <!-- KETIKA DI TERIMA -->
                                <div id="form-diterima" class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="no_surat" class="form-label">Nomor Surat</label>
                                        <input type="text" class="form-control" id="no_surat" name="no_surat"
                                            value="{{ $pendaftaransurat->no_surat }}" placeholder="Nomor Surat">
                                    </div>
                                </div>

                                <!-- KETIKA DI TOLAK -->
                                <div id="form-ditolak" class="row mt-3" style="display: none;">
                                    <div class="col-md-12">
                                        <label for="komentar" class="form-label">Komentar</label>
                                        <textarea class="form-control" id="komentar" name="komentar" rows="3" placeholder="Komentar">{{ $pendaftaransurat->komentar }}</textarea>

                                    </div>
                                </div>





                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5 mt-3">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to the radio buttons and form sections
            const diterimaRadio = document.getElementById('success-outlined');
            const ditolakRadio = document.getElementById('danger-outlined');
            const formDiterima = document.getElementById('form-diterima');
            const formDitolak = document.getElementById('form-ditolak');

            // Function to toggle the visibility of the forms based on selected status
            function toggleForms() {
                if (diterimaRadio.checked) {
                    formDiterima.style.display = 'block';
                    formDitolak.style.display = 'none';
                } else if (ditolakRadio.checked) {
                    formDiterima.style.display = 'none';
                    formDitolak.style.display = 'block';
                }
            }

            // Add event listeners to the radio buttons
            diterimaRadio.addEventListener('change', toggleForms);
            ditolakRadio.addEventListener('change', toggleForms);

            // Initial call to set the correct form visibility
            toggleForms();
        });
    </script>
@endsection
