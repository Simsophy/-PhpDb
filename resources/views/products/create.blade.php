@extends('layouts.app')

@section('title', 'Create Product')
@section('page_title', 'Create Product')

@section('content')
<div class="card mt-3">
    <div class="card-body">
        <form action="{{ route('product.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="code">Product Code</label>
                <input type="text" name="code" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" required step="0.01">
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="unit_id">Unit</label>
                <select name="unit_id" class="form-control" required>
                    <option value="">-- Select Unit --</option>
                    @foreach($units as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="alert">Alert Quantity</label>
                <input type="number" name="alert" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Save Product</button>
            <a href="{{ route('product.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
