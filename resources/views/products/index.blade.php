<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Products</h1>
    
    <!-- Add Product Button -->
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Add Product</a>
    
    <!-- Search Form -->
    <form action="{{ route('products.index') }}" method="GET" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search by ID or Description" value="{{ request()->search }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Sorting Links -->
    <a href="{{ route('products.index', ['sort_by' => 'name']) }}" class="btn btn-link">Sort by Name</a>
    <a href="{{ route('products.index', ['sort_by' => 'price']) }}" class="btn btn-link">Sort by Price</a>

    <!-- Products Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        <!-- Display the image if exists -->
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $products->links() }}
@endsection