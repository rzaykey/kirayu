@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="">File Shared</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/dashboard" class="text-reset">Home</a>
                <span>/</span>
                <a href="/document/shared" class="text-reset">File Shared</a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
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
                <div class="col-auto">
                    <div class="form-group">
                        <label class="mb-2"><strong>Unit :</strong></label>
                        <select id='unit_id' class="form-control" style="width: 200px">
                            <option value="">-- Pilih --</option>
                            @foreach ($unit as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-auto">
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
                <div class="col">
                    <div class="form-group">
                        <label class="mb-2"><strong>Reset :</strong></label><br>
                        <button type="button" id="resetFilter" href="/document/shared" class="btn btn-primary">
                            <span data-feather="refresh-ccw"></span>
                        </button>
                    </div>
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
                        <th scope="col">Kategori</th>
                        <th scope="col">Author</th>
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
            function applyFeatherIcons() {
                feather.replace();
            }
            var table = $('.document_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('/document/shared') }}",
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
                        data: 'categories',
                        name: 'name',
                        searchable: false
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
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
                ],
                drawCallback: function() {
                    // Call the applyFeatherIcons function when the table is drawn (e.g., during pagination)
                    applyFeatherIcons();
                }
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
            applyFeatherIcons();
        });
    </script>
@endsection
