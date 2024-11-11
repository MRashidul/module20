<!-- resources/views/products/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Product Details</h1>

    <p><strong>Product ID:</strong> {{ $product->product_id }}</p>
    <p><strong>Name:</strong> {{ $product->name }}</p>
    <p><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    
    @if($product->image)
        <p><strong>Image:</strong></p>
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="200">
    @endif

    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
@endsection