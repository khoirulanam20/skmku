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
                            <li class="breadcrumb-item active" aria-current="page">Edit Pendaftaran Skripsi</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <div class="row">
                <div class="col-xl-7 mx-auto">
                    <hr />
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-primary"></i></div>
                                <h5 class="mb-0 text-primary">Edit Pendaftaran Skripsi</h5>
                            </div>
                            <hr>
                            <form action="{{ route('pendaftaranskripsi.update', $pendaftaranskripsi->id) }}" method="POST"
                                enctype="multipart/form-data" class="row g-3">
                                @csrf
                                @method('PUT')
                                <div class="col-md-6">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $mahasiswa->nama }}" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim"
                                        value="{{ $mahasiswa->nim }}" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Telepon</label>
                                    <input type="text" class="form-control" id="telepon" name="telepon"
                                        value="{{ $mahasiswa->telepon }}" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="judul_skripsi" class="form-label">Judul Skripsi</label>
                                    <input type="text" class="form-control" id="judul_skripsi" name="judul_skripsi"
                                        value="{{ $pendaftaranskripsi->judul_skripsi }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="peminatan" class="form-label">Peminatan</label>
                                    <select class="form-control" id="peminatan" name="peminatan" required>
                                        <option value="">Pilih Peminatan</option>
                                        <option value="AKK" {{ $pendaftaranskripsi->peminatan == 'AKK' ? 'selected' : '' }}>AKK</option>
                                        <option value="K3" {{ $pendaftaranskripsi->peminatan == 'K3' ? 'selected' : '' }}>K3</option>
                                        <option value="Epidemiologi" {{ $pendaftaranskripsi->peminatan == 'Epidemiologi' ? 'selected' : '' }}>Epidemiologi</option>
                                        <option value="Promosi Kesehatan" {{ $pendaftaranskripsi->peminatan == 'Promosi Kesehatan' ? 'selected' : '' }}>Promosi Kesehatan</option>
                                        <option value="Manajemen Informasi Kesehatan" {{ $pendaftaranskripsi->peminatan == 'Manajemen Informasi Kesehatan' ? 'selected' : '' }}>Manajemen Informasi Kesehatan</option>
                                    </select>
                                </div>
                                

                                <div class="col-md-6">
                                    <label for="pembimbing_id" class="form-label">Dosen Pembimbing</label>
                                    <select class="form-select" id="pembimbing_id" name="pembimbing_id" required>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->user_id }}"
                                                {{ $pendaftaranskripsi->pembimbing_id == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="ketua_penguji_id" class="form-label">Dosen Ketua Penguji</label>
                                    <select class="form-select" id="ketua_penguji_id" name="ketua_penguji_id" required>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->user_id }}"
                                                {{ $pendaftaranskripsi->ketua_penguji_id == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="penguji_id" class="form-label">Dosen Penguji</label>
                                    <select class="form-select" id="penguji_id" name="penguji_id" required>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->user_id }}"
                                                {{ $pendaftaranskripsi->penguji_id == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- File upload fields -->
                             
                                <div class="col-md-6">
                                    <label for="file_persetujuan_pendaftaran_sidang_skripsi" class="form-label">Persetujuan Pendaftaran Sidang Skripsi</label>
                                    <input type="file" class="form-control" id="file_persetujuan_pendaftaran_sidang_skripsi" name="file_persetujuan_pendaftaran_sidang_skripsi">
                                    <a href="{{ asset('dokumen/persetujuan_pendaftaran_sidang_skripsi/' . basename($pendaftaranskripsi->file_persetujuan_pendaftaran_sidang_skripsi)) }}" target="_blank">Lihat Persetujuan Pendaftaran Sidang Skripsi</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="dokumen_pendaftaran_ujian_skripsi" class="form-label">Pendaftaran Ujian Skripsi</label>
                                    <input type="file" class="form-control" id="dokumen_pendaftaran_ujian_skripsi" name="dokumen_pendaftaran_ujian_skripsi">
                                    <a href="{{ asset('dokumen/pendaftaran_ujian_skripsi/' . basename($pendaftaranskripsi->dokumen_pendaftaran_ujian_skripsi)) }}" target="_blank">Lihat Pendaftaran Ujian Skripsi</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="kartu_bimbingan" class="form-label">Kartu Bimbingan</label>
                                    <input type="file" class="form-control" id="kartu_bimbingan" name="kartu_bimbingan">
                                    <a href="{{ asset('dokumen/kartu_bimbingan/' . basename($pendaftaranskripsi->kartu_bimbingan)) }}" target="_blank">Lihat Kartu Bimbingan</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="dokumen_kartu_rencana_studi" class="form-label">Kartu Rencana Studi</label>
                                    <input type="file" class="form-control" id="dokumen_kartu_rencana_studi" name="dokumen_kartu_rencana_studi">
                                    <a href="{{ asset('dokumen/kartu_rencana_studi/' . basename($pendaftaranskripsi->dokumen_kartu_rencana_studi)) }}" target="_blank">Lihat Kartu Rencana Studi</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="dokumen_transkrip_nilai" class="form-label">Transkrip Nilai</label>
                                    <input type="file" class="form-control" id="dokumen_transkrip_nilai" name="dokumen_transkrip_nilai">
                                    <a href="{{ asset('dokumen/transkrip_nilai/' . basename($pendaftaranskripsi->dokumen_transkrip_nilai)) }}" target="_blank">Lihat Transkrip Nilai</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="dokumen_bebas_biaya_administrasi" class="form-label">Bebas Biaya Administrasi</label>
                                    <input type="file" class="form-control" id="dokumen_bebas_biaya_administrasi" name="dokumen_bebas_biaya_administrasi">
                                    <a href="{{ asset('dokumen/bebas_biaya_administrasi/' . basename($pendaftaranskripsi->dokumen_bebas_biaya_administrasi)) }}" target="_blank">Lihat Bebas Biaya Administrasi</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="dokumen_bebas_pinjaman_perpustakaan" class="form-label">Bebas Pinjaman Perpustakaan</label>
                                    <input type="file" class="form-control" id="dokumen_bebas_pinjaman_perpustakaan" name="dokumen_bebas_pinjaman_perpustakaan">
                                    <a href="{{ asset('dokumen/bebas_pinjaman_perpustakaan/' . basename($pendaftaranskripsi->dokumen_bebas_pinjaman_perpustakaan)) }}" target="_blank">Lihat Bebas Pinjaman Perpustakaan</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="dokumen_ijazah_terakhir" class="form-label">Ijazah Terakhir</label>
                                    <input type="file" class="form-control" id="dokumen_ijazah_terakhir" name="dokumen_ijazah_terakhir">
                                    <a href="{{ asset('dokumen/ijazah_terakhir/' . basename($pendaftaranskripsi->dokumen_ijazah_terakhir)) }}" target="_blank">Lihat Ijazah Terakhir</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="dokumen_fotocopy_toefl" class="form-label">Fotocopy TOEFL</label>
                                    <input type="file" class="form-control" id="dokumen_fotocopy_toefl" name="dokumen_fotocopy_toefl">
                                    <a href="{{ asset('dokumen/fotocopy_toefl/' . basename($pendaftaranskripsi->dokumen_fotocopy_toefl)) }}" target="_blank">Lihat Fotocopy TOEFL</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="dokumen_input_skpi" class="form-label">Input SKPI</label>
                                    <input type="file" class="form-control" id="dokumen_input_skpi" name="dokumen_input_skpi">
                                    <a href="{{ asset('dokumen/input_skpi/' . basename($pendaftaranskripsi->dokumen_input_skpi)) }}" target="_blank">Lihat Input SKPI</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="draft_skripsi" class="form-label">Draft Skripsi</label>
                                    <input type="file" class="form-control" id="draft_skripsi" name="draft_skripsi">
                                    <a href="{{ asset('dokumen/draft_skripsi/' . basename($pendaftaranskripsi->draft_skripsi)) }}" target="_blank">Lihat Draft Skripsi</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="dokumen_artikel_ilmiah" class="form-label">Artikel Ilmiah</label>
                                    <input type="file" class="form-control" id="dokumen_artikel_ilmiah" name="dokumen_artikel_ilmiah">
                                    <a href="{{ asset('dokumen/artikel_ilmiah/' . basename($pendaftaranskripsi->dokumen_artikel_ilmiah)) }}" target="_blank">Lihat Artikel Ilmiah</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="file_turnitin" class="form-label">File Turnitin</label>
                                    <input type="file" class="form-control" id="file_turnitin" name="file_turnitin">
                                    <a href="{{ asset('dokumen/turnitin/' . basename($pendaftaranskripsi->file_turnitin)) }}" target="_blank">Lihat File Turnitin</a><br>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="bukti_pendaftaran_siadin" class="form-label">Bukti Pendaftaran SIADIN</label>
                                    <input type="file" class="form-control" id="bukti_pendaftaran_siadin" name="bukti_pendaftaran_siadin">
                                    <a href="{{ asset('dokumen/bukti_pendaftaran_siadin/' . basename($pendaftaranskripsi->bukti_pendaftaran_siadin)) }}" target="_blank">Lihat Bukti Pendaftaran SIADIN</a><br>
                                </div>
                                
                                
                                


                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
