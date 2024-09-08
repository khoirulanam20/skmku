@extends('template-admin.layout')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Forms</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Master Wilayah</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <h6 class="mb-0 text-uppercase">Data Master Wilayah Kabupaten Kuantan Singingi</h6>
        <hr/>

        <!-- Instructions and Actions -->
        <div class="mb-3">
            <div class="alert alert-warning border-0 bg-warning alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-dark"><i class='bx bx-info-circle'></i></div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-dark">Warning</h6>
                        <div class="text-dark">Ambil data Kecamatan terlebih dahulu, kemudian ambil data Kelurahan. Jangan keliru!</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <button id="deleteAllButton" class="btn btn-danger mb-2">Hapus Semua Data</button>
            <a href="/save-kecamatan" class="btn btn-success mb-2">Ambil data Kecamatan</a>
            <a href="/save-kelurahan" class="btn btn-success mb-2">Ambil data Kelurahan</a>
        </div>
        <!-- End Instructions and Actions -->

        <!-- Tables -->
        <div class="row">
            <!-- Kecamatan Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama Kecamatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kec as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->kecamatan_id }}</td>
                                    <td>{{ $p->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama Kecamatan</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Kecamatan Table -->

            <!-- Kelurahan Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama Kelurahan</th>
                                    <th>Nama Kecamatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kel as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->kelurahan_id }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->kecamatan->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama Kelurahan</th>
                                    <th>Nama Kecamatan</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Kelurahan Table -->
        </div>
        <!-- End Tables -->
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('deleteAllButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua data kecamatan dan kelurahan akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus semua!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form to delete all data
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('wilayah.deleteAll') }}';
                form.innerHTML = '@csrf';
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}'
    });
    @endif
</script>
@endsection
