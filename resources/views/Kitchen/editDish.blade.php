@extends('Kitchen.layout')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid px-5">
            <div class="card">
                <div class="card-header">
                  <h2 class="card-title h3">Edit Dishes</h2>
                  <a href="{{ route('dish#index') }}" class=" float-right btn btn-light"><i class="fa-solid fa-arrow-left"></i> Back</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <form action="{{ route('dish#update',$data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label">Dish Name</label>
                      <input type="text" name="name" value="{{ old('name',$data->name) }}" class="form-control">
                      @error('name')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Category</label>
                      <select name="category_id" class="form-select form-control">
                        @foreach ($categories as $category)
                          <option value="{{ $category->id }}" @if ($category->id == $data->category_id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                      </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dish Price</label>
                        <input type="number" name="price" value="{{ old('price',$data->price) }}" class="form-control">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <img class=" w-25 h-auto" src="{{ asset('storage/'.$data->image) }}" alt="">
                        <label for="formFile" class="form-label">Dishes Image</label>
                        <input class="form-control" name="image" type="file" id="formFile">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
                </div>
                <!-- /.card-body -->
              </div>
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
@endsection
