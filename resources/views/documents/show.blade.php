@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="">Data File</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/dashboard" class="text-reset">Home</a>
                <span>/</span>
                <a href="/documents" class="text-reset">Documents</a>
                <span>/</span>
                <a href="" class="text-reset"><u>{{ $documents->name }}</u></a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <div class="container-iframe py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9">
                <div class="card mb-9" bo>
                    <div class="col">
                        <div class="mb-2">
                            <div class="card-body text-center">
                                <h5 class="my-3">{{ $documents->name }}</h5>
                                <iframe class="responsive-iframe" src="{{ asset('storage/' . $documents->images) }}"
                                    height="620" width="100%" frameborder="0" scrolling="auto"></iframe>
                                {{-- @if ($documents->type == 'pdf')
                                    <iframe class="responsive-iframe" src="{{ asset('storage/' . $documents->images) }}"
                                        height="620" width="100%" frameborder="0" scrolling="auto"></iframe>
                                @else
                                    <p class="text-muted text-center">File tidak bisa dilihat, harap didownload !!</p>
                                @endif --}}
                                <p class="text-muted text-end">Last update : {{ $documents->updated_at }}</p>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="/documents/{{ $documents->id }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="row d-flex justify-content-center h-100 align-items-center"
                            style="align-content: center">
                            <div class="col col-lg-9 mb-2">
                                <div class="card-body">
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

                                        <div class="col">
                                            <label for="unit_id" class="form-label">Bagikan : </label> <br>
                                            @foreach ($units as $units)
                                                <input @if ($documents->unit()->where('units_id', $units->id)->exists()) checked @endif type="checkbox"
                                                    name="unit_id[]" value="{{ $units->id }}">
                                                {{ $units->name }}
                                                <br />
                                            @endforeach
                                            </select>
                                            @error('units_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-2">
                                            <p class="mb-0">Author</p>
                                            <p class="text-muted mb-0">{{ $documents->created_by }}</p>
                                        </div>
                                        <div class="col-2">
                                            <p class="mb-0">Type </p>
                                            <p class="text-muted mb-0">{{ $documents->type }}</p>
                                        </div>
                                        <div class="col-2">
                                            <p class="mb-0">Ukuran </p>
                                            <p class="text-muted mb-0">{{ $documents->size }} Kb</p>
                                        </div>
                                        <div class="col-3">
                                            <p class="mb-0">Kategori</p>
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
                                        {{-- <div class="col-3">
                                            <p class="mb-0">Unit</p>
                                            <select class="form-select" name="unit_id">
                                                @foreach ($units as $units)
                                                    @if (old('unit_id', $documents->units_id) == $units->id)
                                                        <option value="{{ $units->id }}" selected>
                                                            {{ $units->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $units->id }}">{{ $units->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div> --}}
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-4">
                                <button type="submit" class="btn btn-info">
                                    <span data-feather="save"></span> Simpan</button>
                                <a href="{{ URL::previous() }}" type="button" class="btn btn-secondary ms-1">
                                    <span data-feather="back"></span> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
