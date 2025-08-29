@extends('layouts.app')

@section('title', 'Edit Company')
@section('page_title', 'Edit Company')

@section('content')
<p class="my-1">
    <a href="{{ route('company.index') }}" class="btn btn-success btn-sm">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</p>

<div class="card">
    <div class="card-body">
        <form action="{{ route('company.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
  


      

            <div class="form-group row">
                <label for="name">Name</label>
                <input id="name" name="name" class="form-control" value="{{ old('name', $company->name) }}">
            </div>

            <div class="form-group row">
                <label for="website">Website</label>
                <input id="website" name="website" class="form-control" value="{{ old('website', $company->website) }}">
            </div>

            <div class="form-group row">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" class="form-control" value="{{ old('phone', $company->phone) }}">
            </div>

            <div class="form-group row">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $company->email) }}">
            </div>

            <div class="form-group row">
                <label for="vattin">VAT/TIN</label>
                <input id="vattin" name="vattin" class="form-control" value="{{ old('vattin', $company->vattin) }}">
            </div>

            <div class="form-group row">
                <label for="address">Address</label>
                <textarea id="address" name="address" class="form-control">{{ old('address', $company->address) }}</textarea>
            </div>

            <div class="form-group row">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $company->description) }}</textarea>
            </div>

            <div class="form-group row">
                <label for="logo">Logo</label>
                <input type="file" id="logo" name="logo" accept="image/*" onchange="preview(event)">
                <div class="mt-2">
                    <img id="img-preview" width="240" src="{{ $company->logo ? asset('storage/' . $company->logo) : asset('images/default-logo.png') }}" alt="logo">
                </div>
            </div>

           <div class="form-group row">
    <label for="map_url" class="col-form-label">Map Embed URL</label>

    <input type="url" name="map_url" value="{{ old('map_url', $company->map_url) }}" class="form-control">

    @if(!empty($company->map_url))
        <div class="mt-3">
            <iframe 
                src="{{ $company->map_url }}" 
                width="700" 
                height="500" 
                style="border:0;" 
                allowfullscreen 
                loading="lazy">
            </iframe>
        </div>
    @endif
</div>

                    
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <a href="{{ route('company.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function preview(e){
    const img = document.getElementById('img-preview');
    img.src = URL.createObjectURL(e.target.files[0]);
    img.onload = () => URL.revokeObjectURL(img.src);
}
</script>

@endsection
