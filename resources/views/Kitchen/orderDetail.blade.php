@extends('Kitchen.layout')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                  <h2 class="card-title h3">Order-Dishes</h2>
                  <a href="{{ route('kitchen#orderList') }}" class=" float-right btn btn-light"><i class="fa-solid fa-arrow-left"></i>Back</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Dish Image</th>
                        <th>Dish Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($dishes as $dish)
                            <tr>
                                <td class="w-25">
                                    <img style="" class="w-50" src="{{ asset('storage/'.$dish->dish->image) }}" alt="">
                                </td>
                                <td>{{ $dish->dish->name }}</td>
                                <td>{{ $dish->dish->category->name }}</td>
                                <td>{{ $dish->dish->price }}</td>
                                <td>{{ $dish->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
@endsection
@section('script')
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,'pageLength':5,'searching':false,
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
@endsection

