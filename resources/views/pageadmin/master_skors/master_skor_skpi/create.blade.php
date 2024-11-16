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
                        <li class="breadcrumb-item active" aria-current="page">Master TINGKAT</li>
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
                <hr/>
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-primary"></i></div>
                            <h5 class="mb-0 text-primary">Tambah Master TINGKAT</h5>
                        </div>
                        <hr>
                        <form action="{{ route('skor.store') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-12">
                                <label for="unsur_id" class="form-label">Nama Unsur SKPI</label>
                                <select class="form-control" id="unsur_id" name="unsur_id" required>
                                    <option value="">Pilih Unsur SKPI</option>
                                    @foreach ($unsur as $unsur)
                                        <option value="{{ $unsur->id }}">{{ $unsur->nama_unsur }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="nama_sub_unsur" class="form-label">Nama Sub Unsur SKPI</label>
                                <label for="" class="form-label text-danger">*kosongkan jika tidak ada</label>
                                <input type="text" class="form-control" id="nama_sub_unsur" name="nama_sub_unsur">
                            </div>
                            <div class="col-md-12">
                                <label for="nama_tingkat" class="form-label">Nama Tingkat SKPI</label>
                                <label for="" class="form-label text-danger">*kosongkan jika tidak ada</label>
                                <input type="text" class="form-control" id="nama_tingkat" name="nama_tingkat">
                            </div>
                            <div class="col-md-12">
                                <label for="skor" class="form-label">SKOR</label>
                                <input type="number" class="form-control" id="skor" name="skor" required>
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
