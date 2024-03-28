@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="">Jabatan</h1>
        <!-- Breadcrumb -->
        <nav class="d-flex">
            <h6 class="mb-0">
                <a href="/dashboard" class="text-reset">Home</a>
                <span>/</span>
                <a href="/roles" class="text-reset">Jabatan</a>
            </h6>
        </nav>
        <!-- Breadcrumb -->
    </div>
    <a type="button" class="btn btn-primary mb-3" href="/roles/create">
        <span data-feather="plus"></span> Tambah
    </a>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow card-body">
        <div class="table-responsive">
            <table class="table table-striped align-end mb-0 bg-white roles_datatable">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
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
            var table = $('.roles_datatable').DataTable({
                processing: true,
                serverSide: true,
                Responsive: true,
                ajax: "{{ url('roles') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'role_name',
                        name: 'role_name'
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
        });
    </script>
@endsection
