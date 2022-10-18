@extends('Kitchen.layout')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
          <div class="row">
            @foreach ($orders as $order)
                <div class="col col-4" id="parent">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title ">Table-{{ $order->table_id }}</h5>
                        <br>
                        <h5 class="card-title my-2">Total-{{ $order->total }}ks</h5>
                        <p class="card-text">Code-{{ $order->order_id }}</p>
                        <a href="{{ route('kitchen#orderDetail',$order->id) }}" class="btn btn-primary">View order dishes</a>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Order-Pending
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item active " href="#">Order-Pending</a></li>
                              <li><a class="dropdown-item" href="{{ route('kitchen#orderReady',$order->id) }}">Order-Ready</a></li>
                              <li><a class="dropdown-item" href="{{ route('kitchen#orderCancel',$order->id) }}">Order-Cancel</a></li>
                            </ul>
                          </div>
                        </div>
                    </div>
                </div>
            @endforeach

          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
@endsection

