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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Pendaftaran Surat</li>
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
                                <h5 class="mb-0 text-primary">Tambah Pendaftaran Surat</h5>
                            </div>
                            <hr>
                            <form action="{{ route('pendaftaransurat.store') }}" method="POST"
                                enctype="multipart/form-data" class="row g-3">
                                @csrf
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
                                    <label for="tujuan_surat" class="form-label">Tujuan Surat</label>
                                    <input type="text" class="form-control" id="tujuan_surat" name="tujuan_surat"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="judul_skripsi" class="form-label">Judul Skripsi</label>
                                    <input type="text" class="form-control" id="judul_skripsi" name="judul_skripsi"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="data_diperlukan_jika_ditujukan_ke_dinkes" class="form-label">Apabila Surat
                                        ditujukan Kepada Dinas Kesehatan Isi Data apa yang hendak di perlukan <span
                                            class="text-danger">(jika diperlukan)</span></label>
                                    <textarea class="form-control" id="data_diperlukan_jika_ditujukan_ke_dinkes"
                                        name="data_diperlukan_jika_ditujukan_ke_dinkes" rows="4"></textarea>
                                </div>


                                <div class="col-md-6">
                                    <label for="surat">Jenis Surat</label>
                                    <select name="surat" id="surat" class="form-control" required>
                                        <option value="">Pilih Surat</option>
                                        <option value="Surat Penelitian">Surat Penelitian</option>
                                        <option value="Surat Studi Pendahuluan">Surat Studi Pendahuluan</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="sub_surat">Sub Surat</label>
                                    <select name="sub_surat" id="sub_surat" class="form-control" required
                                        onchange="handleSubSuratChange(this)">
                                        <option value="">Pilih Sub Surat</option>
                                        <option value="Non Payung">Non Payung</option>
                                        <option value="Payung">Payung</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <div id="payungFields" style="display:none;">
                                        <h4>Masukkan Nama Mahasiswa</h4>
                                        <div id="mahasiswaPayungContainer">
                                            <!-- Mahasiswa Payung Form Group (Nama & NIM) -->
                                            <div class="form-row mb-3" id="mahasiswaPayung0">
                                                <div class="col">
                                                    <input type="text" name="mahasiswa_payung[0][nama]"
                                                        class="form-control" placeholder="Nama Mahasiswa" required>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="mahasiswa_payung[0][nim]"
                                                        class="form-control" placeholder="NIM Mahasiswa" required>
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeMahasiswaField('mahasiswaPayung0')">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Button to add more mahasiswa payung -->
                                        <button type="button" class="btn btn-primary"
                                            onclick="addMahasiswaField()">Tambah Mahasiswa</button>
                                    </div>
                                </div>



                                <!-- File upload fields -->


                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">Simpan</button>
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
        let mahasiswaCount = 1;

        // Function to handle sub_surat change
        function handleSubSuratChange(select) {
            const payungFields = document.getElementById('payungFields');
            const payungInputs = document.querySelectorAll('#payungFields input');

            if (select.value === 'Payung') {
                payungFields.style.display = 'block';
                // Add 'required' attribute to payung inputs
                payungInputs.forEach(input => input.required = true);
            } else {
                payungFields.style.display = 'none';
                // Remove 'required' attribute from payung inputs
                payungInputs.forEach(input => input.required = false);
            }
        }

        // Function to add more mahasiswa payung fields dynamically
        function addMahasiswaField() {
            const container = document.getElementById('mahasiswaPayungContainer');
            const newFieldId = `mahasiswaPayung${mahasiswaCount}`;
            const newField = document.createElement('div');
            newField.classList.add('form-row', 'mb-3');
            newField.id = newFieldId;
            newField.innerHTML = `
        <div class="col">
            <input type="text" name="mahasiswa_payung[${mahasiswaCount}][nama]" class="form-control" placeholder="Nama Mahasiswa" required>
        </div>
        <div class="col">
            <input type="text" name="mahasiswa_payung[${mahasiswaCount}][nim]" class="form-control" placeholder="NIM Mahasiswa" required>
        </div>
        <div class="col">
            <button type="button" class="btn btn-danger" onclick="removeMahasiswaField('${newFieldId}')">Hapus</button>
        </div>
    `;
            container.appendChild(newField);
            mahasiswaCount++;
        }

        // Function to remove mahasiswa payung fields dynamically
        function removeMahasiswaField(fieldId) {
            const field = document.getElementById(fieldId);
            field.remove();
        }
    </script>
@endsection
