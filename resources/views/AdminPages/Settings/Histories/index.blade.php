@extends('Templates.admin')

@section('title', 'History Models')

@push('css')
<style>
  .dataTables_length {
    display: none !important;
  }
  pre {
    white-space: pre-wrap;
    font-size: 12px;
  }
</style>
@endpush

@section('content-header')
<div class="d-flex justify-content-between align-items-center">
    <h1>History Models</h1>
    <div aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route(\App\Constants\Routes::routeAdminDashboard) }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Model History
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card p-3">
    <div class="card-header">
        <div class="row align-items-center gap-2">

            {{-- Select Entries --}}
            <div class="col-md-2 col-12 d-flex align-items-center">
                <h6 class="mb-0 me-2">Show</h6>
                <select id="entries" class="form-control form-control-sm w-auto">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <h6 class="mb-0 ms-2">entries</h6>
            </div>

            {{-- Filter Model --}}
            <div class="col-md-3 col-12">
                <select id="filter-model" class="form-control form-control-sm">
                    <option value="">All Model</option>
                    @foreach ($models as $model)
                        <option value="{{ $model }}">
                            {{ class_basename($model) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter User --}}
            <div class="col-md-3 col-12">
                <select id="filter-user" class="form-control form-control-sm">
                    <option value="">All User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Search --}}
            <div class="col-md-3 col-12">
                <form class="d-flex justify-content-end">
                    <div class="input-group">
                        <input id="datatable-search" type="text" class="form-control" placeholder="Search">
                        <button id="basic-addon2" type="button"
                            class="input-group-text btn btn-info btn-sm btn-flat">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Model</th>
                        <th>Action</th>
                        <th>Before</th>
                        <th>After</th>
                        <th>User</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- serverSide Datatable --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    var table

    $(function () {

        $('#datatable-search').keyup(function(){
            $('#datatable').DataTable().search($(this).val()).draw();
        })

        table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url()->current() }}",
                data: function(d) {
                    d.model = $("#filter-model").val()
                    d.user  = $("#filter-user").val()
                }
            },
            "drawCallback": function () {
                $('.dataTables_paginate > .paginate_button').addClass('page-link p-2');
            },
            pageLength: 5,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
                {data: 'model',      name: 'model'},
                {data: 'action',     name: 'action'},
                {data: 'before',     name: 'before', orderable:false, searchable:false},
                {data: 'after',      name: 'after',  orderable:false, searchable:false},
                {data: 'user',       name: 'user'},
                {data: 'created_at', name: 'created_at'},
            ]
        });

        // Change page length
        $('#entries').on('change', function () {
            let value = $(this).val();
            table.page.len(value).draw();
        });

        // Trigger when filter changed
        $('#filter-model, #filter-user').on('change', function () {
            table.ajax.reload();
        });

        $('.dataTables_filter').addClass('d-none')
    });
</script>
@endpush
