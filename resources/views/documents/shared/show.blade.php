@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="">{{ $title }} Shared</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/dashboard" class="text-reset">Home</a>
                <span>/</span>
                <a href="/documents" class="text-reset">File Shared</a>
                <span>/</span>
                <a href="" class="text-reset"><u>{{ $documents->name }}</u></a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <div class="container-iframe py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9">
                <div class="card shadow mb-3">
                    <div class="col">
                        <div class="mb-2">
                            <div class="card-body text-center">
                                <h5 class="my-3">{{ $documents->name }}</h5>
                                @if ($documents->type == 'pdf')
                                    <iframe class="responsive-iframe" src="{{ asset('storage/' . $documents->images) }}"
                                        height="620" width="100%" frameborder="0" scrolling="auto"></iframe>
                                @else
                                    <p class="text-muted text-center">File tidak bisa dilihat, harap didownload !!</p>
                                @endif
                                <div class="row">
                                    <div class="col">
                                        <p class="text-muted text-start">Date Upload : {{ $documents->updated_at }}</p>
                                    </div>
                                    <div class="col">
                                        <p class="text-muted mb-0">Author : {{ $documents->created_by }}</p>
                                    </div>
                                    <div class="col">
                                        <p class="text-muted mb-0">Size : {{ $documents->size }} Kb</p>
                                    </div>
                                    <div class="col">
                                        <p class="text-muted text-end">Last update : {{ $documents->updated_at }}</p>
                                    </div>
                                    <i class="text-muted text-center">Keterangan :
                                        {{ $documents->keterangan }}
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" action="/document/arsip/{{ $documents->id }}" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row d-flex justify-content-center h-100 align-items-center" style="align-content: center">
                        <div class="d-flex justify-content-center mb-4">
                            <a href="{{ URL::previous() }}" type="button" class="btn btn-secondary ms-1">
                                <span data-feather="back"></span> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
