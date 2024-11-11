<!-- resources/views/products/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Create Product</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="product_id">Product ID</label>
            <input type="text" name="product_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-success">Create Product</button>
    </form>
@endsection