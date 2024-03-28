@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="">Arsip Perpustakaan</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/dashboard" class="text-reset">Home</a>
                <span>/</span>
                <a href="/document/arsip" class="text-reset">Arsip Perpustakaan</a>
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
                                {{-- @if ($documents->type !== 'pdf')
                                    <p class="text-muted text-center">File tidak bisa dilihat, harap didownload !!</p>
                                @else
                                    <iframe class="responsive-iframe" src="{{ asset('storage/' . $documents->images) }}"
                                        height="620" width="100%" frameborder="0" scrolling="auto"></iframe>
                                @endif --}}
                                <iframe class="responsive-iframe" src="{{ asset('storage/' . $documents->images) }}"
                                    height="620" width="100%" frameborder="0" scrolling="auto"></iframe>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" action="/document/arsip/{{ $documents->id }}" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row d-flex justify-content-center h-100 align-items-center" style="align-content: center">
                        @can('is_perpustakaan')
                            <div class="col col-lg-9 mb-2">
                                <div class="card-body shadow">
                                    <div class="row">
                                        <div class="col mb-2">
                                            <label for="images" class="form-label">Keterangan</label>
                                            <input type="text"
                                                class="form-control mb-3 @error('keterangan') is-invalid @enderror"
                                                id="keterangan" name="keterangan" required
                                                value="{{ old('keterangan', $documents->keterangan) }}">
                                            @error('keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-auto">
                                            <div class="mb-0">
                                                <label for="images" class="form-label">Document</label>
                                                <input type="hidden" name="oldName" value="{{ $documents->name }}">
                                                <input type="hidden" name="oldImage" value="{{ $documents->images }}">
                                                <input class="mb-3 form-control @error('images') is-invalid @enderror"
                                                    type="file" id="images" name="images">
                                                @error('images')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <label for="images" class="form-label">Kategori</label>
                                            <select class="form-select" name="categories_id">
                                                @foreach ($categories as $categories)
                                                    @if (old('categories_id', $documents->categories_id) == $categories->id)
                                                        <option value="{{ $categories->id }}" selected>
                                                            {{ $categories->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $categories->id }}">{{ $categories->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('categories_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        @endcan
                        <div class="d-flex justify-content-center mb-4">
                            @can('is_perpustakaan')
                                <button type="submit" class="btn btn-info">
                                    <span data-feather="save"></span> Simpan</button>
                            @endcan
                            <a href="{{ URL::previous() }}" type="button" class="btn btn-secondary ms-1">
                                <span data-feather="back"></span> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
