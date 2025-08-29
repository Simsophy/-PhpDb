@extends('layouts.app')

@section('title', 'Product Details')
@section('page_title', 'Product Details')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3>{{ $product->name }} (Code: {{ $product->code }})</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>Product Code</th>
                    <td>{{ $product->code }}</td>
                </tr>
                <tr>
                    <th>Product Name</th>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{ number_format($product->price, 2) }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $product->category_name }}</td>
                </tr>
                <tr>
                    <th>Unit</th>
                    <td>{{ $product->unit_name }}</td>
                </tr>
                <tr>
                    <th>Alert Quantity</th>
                    <td>{{ $product->alert }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $product->description ?? 'No description provided.' }}</td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('product.index') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Back to Product List
        </a>
    </div>
</div>
@endsection
