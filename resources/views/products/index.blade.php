@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="">Manajemen Barang</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/dashboard" class="text-reset">Home</a>
                <span>/</span>
                <a href="/products" class="text-reset">Barang</a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <a type="button" class="btn btn-primary mb-3" href="/products/create">
        <span data-feather="plus"></span> Tambah
    </a>
    <a type="button" id="resetFilter" href="/products" class="btn btn-primary-outline mb-3">
        <span data-feather="refresh-ccw"></span>
    </a>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow card-body mb-3">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="mb-2"><strong>Kategori :</strong></label>
                    <select id='categories_id' class="form-control" style="width: 200px">
                        <option value="">-- Pilih --</option>
                        @foreach ($categories as $categories)
                            <option value="{{ $categories->id }}">{{ $categories->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="mb-2"><strong>Author :</strong></label>
                    <select id='author' class="form-control" style="width: 200px">
                        <option value="">-- Pilih --</option>
                        @foreach ($author as $author)
                            <option value="{{ $author->name }}">{{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow card-body">
        <div class="table-responsive">
            <table class="table table-striped align-end mb-0 bg-white document_datatable">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {

            var table = $('.document_datatable').DataTable({
                processing: true,
                serverSide: true,
                Responsive: true,
                ajax: {
                    url: "{{ url('products') }}",
                    data: function(d) {
                        d.categories_id = $('#categories_id').val(),
                            d.author = $('#author').val(),
                            d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    }, {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'categories',
                        name: 'name',
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#categories_id').change(function() {
                table.draw();
            });
            $('#unit_id').change(function() {
                table.draw();
            });
            $('#author').change(function() {
                table.draw();
            });
            $("#filter").change(function() {
                table.draw();
            });
        });
    </script>
@endsection
