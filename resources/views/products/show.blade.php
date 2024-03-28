@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="">Data Barang</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/dashboard" class="text-reset">Home</a>
                <span>/</span>
                <a href="/products" class="text-reset">Barang</a>
                <span>/</span>
                <a href="" class="text-reset"><u>{{ $products->name }}</u></a>
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
                                <h5 class="my-3">{{ $products->name }}</h5>
                                <img class="responsive-iframe" src="{{ asset('storage/' . $products->images) }}"
                                    height="20%" width="20%" frameborder="0" scrolling="auto"></img>
                                <p class="text-muted text-end">Last update : {{ $products->updated_at }}</p>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="/products/{{ $products->id }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="row d-flex justify-content-center h-100 align-items-center"
                            style="align-content: center">
                            <div class="col col-lg-9 mb-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mb-2">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text"
                                                class="form-control mb-3 @error('description') is-invalid @enderror"
                                                id="name" name="name" required
                                                value="{{ old('name', $products->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <label for="images" class="form-label">Keterangan</label>
                                            <input type="text"
                                                class="form-control mb-3 @error('description') is-invalid @enderror"
                                                id="description" name="description" required
                                                value="{{ old('description', $products->description) }}">
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-0">
                                            <label for="images" class="form-label">Barang</label>
                                            <input type="hidden" name="oldImage" value="{{ $products->images }}">
                                            <input class="mb-3 form-control @error('images') is-invalid @enderror"
                                                type="file" id="images" name="images">
                                            @error('images')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <p class="mb-0">Author</p>
                                            <p class="text-muted mb-0">{{ $products->created_by }}</p>
                                        </div>
                                        <div class="col">
                                            <p class="mb-0">Kategori</p>
                                            <select class="form-select" name="categories_id">
                                                @foreach ($categories as $categories)
                                                    @if (old('categories_id', $products->categories_id) == $categories->id)
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
                                        <div class="col">
                                            <p class="mb-0">Harga</p>
                                            <input type="text"
                                                class="form-control mb-3 @error('price') is-invalid @enderror"
                                                id="price" name="price" required
                                                value="{{ old('price', $products->price) }}">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <p class="mb-0">QTY</p>
                                            <input type="text"
                                                class="form-control mb-3 @error('qty') is-invalid @enderror" id="qty"
                                                name="qty" required value="{{ old('qty', $products->qty) }}">
                                            @error('qty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
