@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="">Manajemen User</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="" class="text-reset">Home</a>
                <span>/</span>
                <a href="" class="text-reset">Analytics</a>
                <span>/</span>
                <a href="" class="text-reset"><u>Dashboard</u></a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <a type="button" class="btn btn-primary mb-3" href="/users/create">
        <span data-feather="plus"></span> Tambah
    </a>
    <div class="card shadow card-body mb-3">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="mb-2"><strong>Role :</strong></label>
                    <select id='roles_id' class="form-control" style="width: 200px">
                        <option value="">-- Pilih --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow card-body">
        <div class="table-responsive">
            <table class="table table-striped users_datatable align-end mb-0 bg-white " id="filterTable">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Dibuat</th>
                        <th scope="col">Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            var table = $('.users_datatable').DataTable({
                processing: true,
                serverSide: true,
                Responsive: true,
                // ajax: "{{ url('users') }}",
                ajax: {
                    url: "{{ url('users') }}",
                    data: function(d) {
                        d.roles_id = $('#roles_id').val(),
                            d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'roles',
                        name: 'role_name',
                        searchable: false
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
                    },
                ]
            });
            $('#roles_id').change(function() {
                table.draw();
            });
        });
    </script>
@endsection
