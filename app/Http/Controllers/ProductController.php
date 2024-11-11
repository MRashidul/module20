<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products with search, sorting, and pagination.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search functionality: filter products based on 'product_id' or 'description'
        if ($request->has('search')) {
            $query->where('product_id', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Sorting functionality: sort products by 'name' or 'price' if requested
        if ($request->has('sort_by') && in_array($request->sort_by, ['name', 'price'])) {
            $query->orderBy($request->sort_by);
        }

        // Paginate the products to display 10 per page
        $products = $query->paginate(10);

        // Return the 'products.index' view with the paginated products
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in the database.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'product_id' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validation for image
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Create a new product
        Product::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => isset($imagePath) ? $imagePath : null, // Store the image path
        ]);

        // Redirect to the product index page with a success message
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product details.
     */
    public function show(string $id)
    {
        // Find the product by ID or throw a 404 error if not found
        $product = Product::findOrFail($id);

        // Return the 'products.show' view with the product data
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(string $id)
    {
        // Find the product by ID or throw a 404 error if not found
        $product = Product::findOrFail($id);

        // Return the 'products.edit' view with the product data
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in the database.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $request->validate([
            'product_id' => 'required|unique:products,product_id,' . $id,
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validation for image
        ]);

        // Find the product by ID or throw a 404 error if not found
        $product = Product::findOrFail($id);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($product->image) {
                \Storage::delete('public/' . $product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Update the product with the new data
        $product->update([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => isset($imagePath) ? $imagePath : $product->image, // Update the image if new image is uploaded
        ]);

        // Redirect to the product index page with a success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from the database.
     */
    public function destroy(string $id)
    {
        // Find the product by ID or throw a 404 error if not found
        $product = Product::findOrFail($id);

        // Delete the product image if exists
        if ($product->image) {
            \Storage::delete('public/' . $product->image);
        }

        // Delete the product
        $product->delete();

        // Redirect to the product index page with a success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}