@extends('layouts.app')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product')

@section('content')
<div class="card mt-3">
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label>Product Code</label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $product->code) }}" required>
      </div>

      <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
      </div>

      <div class="form-group">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="category_id" class="form-control" required>
          @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Unit</label>
        <select name="unit_id" class="form-control" required>
          @foreach ($units as $unit)
            <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
              {{ $unit->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Alert Quantity</label>
        <input type="number" name="alert" class="form-control" value="{{ old('alert', $product->alert) }}">
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
      <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
@endsection
