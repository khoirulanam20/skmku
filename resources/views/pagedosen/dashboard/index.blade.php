@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 text-center mb-4">
                    <img src="{{ asset('env') }}/logoskmku.jpg" width="250" alt="Logo SkripsiKU"
                            class="img-fluid">
                        <p class="mt-3">
                            Selamat datang di <strong>SKMKU</strong>, Skripsi dan SKPI Sarjana Kesehatan Masyarakat
                            Kampus UDINUS merupakan sistem informasi yang dirancang untuk memudahkan pengelolaan skripsi
                            dan SKPI di Program Studi Sarjana Kesehatan Masyarakat. Platform ini merupakan bagian dari
                            layanan unggulan Universitas Dian Nuswantoro (UDINUS) untuk mendukung proses akademik secara
                            modern dan efisien.
                        </p>
                </div>
            </div>
        </div>
    </div>
@endsection
