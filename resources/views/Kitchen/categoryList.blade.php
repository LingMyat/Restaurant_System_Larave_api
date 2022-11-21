@extends('Kitchen.layout')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                  <h2 class="card-title h3">Categories</h2>
                  <button class="float-right btn btn-light" id="create_Btn">Create+</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="d-none">id</th>
                                <th>Category Name</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="d-none"><input type="number" class="id" value="{{ $category->id }}" >
                                <td><input type="text" class="name" value="{{ $category->name }}"></td>
                                <td>{{ $category->created_at }}</td>
                                <td>
                                    <button class=" btn btn-warning update_Btn" id="">Update</button>
                                    <a href="{{ route('kitchen#categoryDelete',$category->id) }}" class=" btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>
      <!-- /.content -->
@endsection
@section('script')
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,'pageLength':6,'searching':false
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
@endsection
