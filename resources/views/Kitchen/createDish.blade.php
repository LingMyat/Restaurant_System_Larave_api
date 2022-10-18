@extends('Kitchen.layout')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid px-5">
            <div class="card">
                <div class="card-header">
                  <h2 class="card-title h3">Create Dishes</h2>
                  <a href="{{ route('dish#index') }}" class=" float-right btn btn-light"><i class="fa-solid fa-arrow-left"></i> Back</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <form action="{{ route('dish#createDish') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label">Dish Name</label>
                      <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                      @error('name')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Category</label>
                      <select name="category_id" class="form-select form-control">
                        <option value="">Select Dishes Category</option>
                        @foreach ($categories as $category)
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                      </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dish Price</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="form-control">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Dishes Image</label>
                        <input class="form-control" name="image" type="file" id="formFile">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                </div>
                <!-- /.card-body -->
              </div>
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
@endsection


