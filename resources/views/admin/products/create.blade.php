@extends('layouts.dashboard')

@section('content')
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="Product name" name="name">
        </div>
        <div class="form-group">
            <label>Brand</label>
            <input type="text" class="form-control" placeholder="Product brand" name="brand">
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" class="form-control" step=".01" name="price">
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" class="form-control" name="quantity">
        </div>
        <div class="form-group">
            <label>Category</label>
            <select class="d-block" name="category_id">
                <option value="">--- Select a category ---</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input class="d-block" type="file" name="image">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="6"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add product</button>
    </form>
@endsection
