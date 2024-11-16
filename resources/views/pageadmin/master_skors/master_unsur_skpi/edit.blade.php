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
                        <li class="breadcrumb-item active" aria-current="page">Master UNSUR</li>
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
                            <h5 class="mb-0 text-primary">Edit Master UNSUR</h5>
                        </div>
                        <hr>
                        <form action="{{ route('unsur.update', $unsur->id) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label for="kategori_id" class="form-label">Nama Kategori SKPI</label>
                                <select class="form-control" id="kategori_id" name="kategori_id" required>
                                    <option value="">Pilih Kategori SKPI</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}" {{ $unsur->kategori_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="nama_unsur" class="form-label">Nama Unsur SKPI</label>
                                <input type="text" class="form-control" id="nama_unsur" name="nama_unsur" value="{{ old('nama_unsur', $unsur->nama_unsur) }}" required>
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