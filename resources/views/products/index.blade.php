@extends('layouts.app')

@section('title', 'Products')

@section('page_title', 'Products')
@section('css')

@endsection

@section('content')
<div class="row py-2">
    <!-- Create Button -->
    <div class="col-sm-3 mb-2">
         
        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm w-70">
            <i class="fas fa-plus-circle"></i> Create Product
        </a>
      
    </div>

    <!-- Export Button -->
    <div class="col-sm-3 mb-2">
        <a href="{{ route('product.export', request()->all()) }}" class="btn btn-success btn-sm w-70">
            <i class="fas fa-file-export"></i> Export CSV
        </a>
    </div>
     <div class="col-sm-6">
<form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit" class="btn btn-primary">Import Excel</button>
</form>
<li class="nav-item">
    <a href="{{ route('product.low') }}" class="nav-link">
        <i class="fas fa-exclamation-circle text-warning"></i> Low Stock
    </a>
</li>

 </div>
    <!-- Search Form -->
    <div class="col-sm-6">
    <form action="{{ route('product.search') }}" method="GET" class="form-inline d-flex align-items-center gap-2">
    
    <label for="cid" class="mb-0 me-2" style="padding-left: 8px; padding-right: 4px;">
        Category:
    </label>
    <select name="cid" id="cid" class="form-select form-select-sm me-3" style="width: auto;">
        <option value="all">All</option>
        @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ request('cid') == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <label for="q" class="mb-0 me-2">Search:</label>
    <input type="text" name="q" id="q" value="{{ request('q') }}" class="form-control form-control-sm me-3" placeholder="Enter name..." style="width: 200px;">

    <button type="submit" class="btn btn-info btn-sm px-3">
        <i class="fas fa-search"></i> Search
    </button>

</form>

    </div>
</div>


<div class="card mt-3">
    <div class="card-body">
        @component('coms.alert') @endcomponent

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Onhand</th>
                    <th>Alert</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
              @foreach ($products as $index => $p)
                    <tr>
                       <td>{{ $products->firstItem() + $index }}</td>
                        <td>{{ $p->code }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->price }}</td>
                        <td>{{ $p->cname }}</td>
                        <td>{{ $p->onhand }}</td>
                        <td>{{ $p->alert }} {{ $p->uname }}</td>
                          <td>

        <a href="{{ route('product.detail', $p->id) }}" class="btn btn-info btn-sm">
            <i class="fas fa-eye"></i> Detail
        </a>

        <a href="{{ route('product.edit', $p->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
        </a>

        <a href="{{ route('product.delete', $p->id) }}" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Are you sure you want to delete this product?');">
           <i class="fas fa-trash"></i> Delete
        </a>
    </td>     
                    </tr>
                @endforeach
            </tbody>
        </table>
   <div class="mt-3">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>

</div>

    </div>
</div>
@endsection
