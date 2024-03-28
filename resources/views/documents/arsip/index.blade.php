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
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    @can('is_perpustakaan')
        <a type="button" class="btn btn-primary mb-3" href="/document/arsip/create">
            <span data-feather="file-plus"></span> Tambah
        </a>
    @endcan
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card card-body shadow mb-3">
        <div class="row justify-content-between">
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
            <div class="col-lg-auto">
                <div class="form-group">
                    <a type="button" id="resetFilter" href="/document/arsip"
                        class="form-control btn btn-primary-outline mb-3">
                        <span data-feather="refresh-ccw"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body shadow">
        <div class="table-responsive">
            <table class="table table-striped align-end mb-0 bg-white document_datatable">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Tanggal Publish</th>
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
                    url: "{{ url('document/arsip') }}",
                    data: function(d) {
                        d.categories_id = $('#categories_id').val(),
                            d.unit_id = $('#unit_id').val(),
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
                        data: 'created_at',
                        name: 'created_at'
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
