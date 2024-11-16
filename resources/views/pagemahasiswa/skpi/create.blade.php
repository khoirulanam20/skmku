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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Pendaftaran Skripsi</li>
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
                                <h5 class="mb-0 text-primary">Tambah Pendaftaran Skpi</h5>
                            </div>
                            <hr>
                            <form action="{{ route('pendaftaranskpi.store') }}" method="POST" enctype="multipart/form-data"
                                class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $mahasiswa->nama }}" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim"
                                        value="{{ $mahasiswa->nim }}" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control" id="telepon" name="telepon"
                                        value="{{ $mahasiswa->telepon }}" readonly required>
                                </div>

                                <div class="col-md-6">
                                    <label for="peminatan" class="form-label">Peminatan</label>
                                    <select class="form-control" id="peminatan" name="peminatan" required>
                                        <option value="">Pilih Peminatan</option>
                                        <option value="AKK">AKK</option>
                                        <option value="K3">K3</option>
                                        <option value="Epidemiologi">Epidemiologi</option>
                                        <option value="Promosi Kesehatan">Promosi Kesehatan</option>
                                        <option value="Manajemen Informasi Kesehatan">Manajemen Informasi Kesehatan</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="tempat_tanggal_lahir" class="form-label">Tempat, Tanggal Lahir</label>
                                    <input type="text" class="form-control" id="tempat_tanggal_lahir" placeholder=""
                                        name="tempat_tanggal_lahir" value="" required>
                                </div>
                                <div id="skorsContainer">
                                    <div class="skors-entry">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                                                <input type="text" class="form-control" placeholder=""
                                                    name="judul_kegiatan[]" value="" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="kategori" class="form-label">Kategori</label>
                                                <select class="form-control kategori-select" name="kategori[]" required>
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="unsur" class="form-label">Unsur</label>
                                                <select class="form-control unsur-select" name="unsur[]" required>
                                                    <option value="">Pilih Unsur</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="skors" class="form-label">Sub Unsur/Tingkat/Skor</label>
                                                <select class="form-control skors-select" name="skors[]" multiple required>
                                                    <!-- Options populated dynamically -->
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-entry mt-3">Remove</button>
                                        <hr />
                                    </div>
                                </div>

                                <button type="button" id="addEntry" class="btn btn-secondary mt-3">Add More</button>
                                <input type="hidden" id="skors_data" name="skors_data">


                                <div class="col-md-6">
                                    <label for="dokumen_kegiatan" class="form-label">Dokumen Kegiatan</label>
                                    <input type="file" class="form-control" id="dokumen_kegiatan"
                                        name="dokumen_kegiatan" required>
                                </div>

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
        document.addEventListener('DOMContentLoaded', function() {
            const skorsContainer = document.getElementById('skorsContainer');
            const addEntryButton = document.getElementById('addEntry');

            // Function to create a new skors entry
            function createSkorsEntry() {
                const newEntry = skorsContainer.querySelector('.skors-entry').cloneNode(true);
                skorsContainer.appendChild(newEntry);

                // Reset dropdown selections and input fields in the new entry
                newEntry.querySelectorAll('select').forEach(select => select.value = "");
                newEntry.querySelectorAll('input').forEach(input => input.value = "");

                // Add event listeners to the new entry
                initializeDynamicFields(newEntry);
            }

            // Initialize fields and event listeners for Kategori and Unsur changes
            function initializeDynamicFields(container) {
                const kategoriSelect = container.querySelector('.kategori-select');
                const unsurSelect = container.querySelector('.unsur-select');
                const skorSelect = container.querySelector('.skors-select');

                kategoriSelect.addEventListener('change', function() {
                    const kategoriId = this.value;
                    unsurSelect.innerHTML = '<option value="">Pilih Unsur</option>';
                    fetch(`/unsurs/${kategoriId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(unsur => {
                                const option = document.createElement('option');
                                option.value = unsur.id;
                                option.textContent = unsur.nama_unsur;
                                unsurSelect.appendChild(option);
                            });
                        });
                });

                unsurSelect.addEventListener('change', function() {
                    const unsurId = this.value;
                    skorSelect.innerHTML = '';
                    fetch(`/skors/${unsurId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(skor => {
                                const option = document.createElement('option');
                                option.value = JSON.stringify({
                                    nama_kategori: kategoriSelect.options[kategoriSelect
                                        .selectedIndex].text,
                                    nama_unsur: unsurSelect.options[unsurSelect
                                        .selectedIndex].text,
                                    nama_sub_unsur: skor.nama_sub_unsur,
                                    nama_tingkat: skor.nama_tingkat,
                                    skor: skor.skor
                                });
                                option.textContent =
                                    `${skor.nama_sub_unsur} / ${skor.nama_tingkat} / ${skor.skor}`;
                                skorSelect.appendChild(option);
                            });
                        });
                });
            }

            // Initial setup for the first entry
            initializeDynamicFields(skorsContainer.querySelector('.skors-entry'));

            // Add new entry when "Add More" button is clicked
            addEntryButton.addEventListener('click', createSkorsEntry);

            // Remove entry when "Remove" button is clicked
            skorsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-entry')) {
                    e.target.closest('.skors-entry').remove();
                }
            });

            // Capture data on form submission
            document.querySelector('form').addEventListener('submit', function(event) {
                const skorsData = Array.from(skorsContainer.querySelectorAll('.skors-entry'))
                    .flatMap(entry => {
                        const judulKegiatan = entry.querySelector('input[name="judul_kegiatan[]"]')
                            .value;
                        const kategoriSelect = entry.querySelector('.kategori-select');
                        const unsurSelect = entry.querySelector('.unsur-select');

                        return Array.from(entry.querySelector('.skors-select').selectedOptions).map(
                            option => {
                                const skorData = JSON.parse(option.value);
                                return {
                                    judul_kegiatan: judulKegiatan,
                                    nama_kategori: skorData.nama_kategori,
                                    nama_unsur: skorData.nama_unsur,
                                    nama_sub_unsur: skorData.nama_sub_unsur,
                                    nama_tingkat: skorData.nama_tingkat,
                                    skor: skorData.skor
                                };
                            });
                    });

                document.getElementById('skors_data').value = JSON.stringify(skorsData);
            });

        });
    </script>
@endsection
