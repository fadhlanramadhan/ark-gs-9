@extends('templates.main')

@section('title_page')
    <h1>Budget</h1>
@endsection

@section('breadcrumb_title')
    budget
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            @if (Session::has('success'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('success') }}
              </div>
            @endif
            <button href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-input"><i class="fas fa-plus"></i> Budget</button>
          </div> <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-striped" id="budget">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Date</th>
                  <th>Project</th>
                  <th>Budget Name</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div> <!-- /.card-body -->
        </div> 
      </div>
    </div>

    <div class="modal fade" id="modal-input">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Input Budget</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('grpo.import_excel') }}" enctype="multipart/form-data" method="POST">
            @csrf
          <div class="modal-body">
              <label>Pilih file excel</label>
              <div class="form-group">
                <input type="file" name='file_upload' required class="form-control">
              </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"> Upload</button>
          </div>
        </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
@endsection

@section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}"/>
@endsection

@section('scripts')
  <!-- DataTables  & Plugins -->
  <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>

  <script>
    $(function () {
      $("#budget").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('budget.data') }}',
        columns: [
          {data: 'DT_RowIndex', orderable: false, searchable: false},
          {data: 'date'},
          {data: 'project_code'},
          {data: 'budget_name'},
          {data: 'amount'},
          {data: 'action'},
        ],
        fixedHeader: true,
        columnDefs: [
              {
                "targets": [4],
                "className": "text-right"
              }
            ]
      })
    });
  </script>

@endsection