@extends('layouts.app')

@section('title', 'Create User')

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap.min.css') }}">
@endsection

@section('content')
<div class="container">
    <h1>Create User</h1>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Create User Form --}}
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mt-2">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mt-2">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control" required>
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mt-2">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

       <div class="form-group mt-2">
    <label for="password">Password <span class="text-danger">*</span></label>
    <input type="password" name="password" id="password" class="form-control" required>
    @error('password')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


        {{-- Role Dropdown --}}
        <x-form.select
            name="role_id"
            title="Role"
            required="required"
            :data="$roles"
            row="row"
        />

       
      <div class="form-group row mt-2">
    <label class="col-sm-3 col-form-label">Language <span class="text-danger">*</span></label>
    <div class="col-sm-9">
        <div class="icheck-success d-inline mr-3">
            <input type="radio" name="lang" id="en" value="en" 
                {{ old('lang', 'en') == 'en' ? 'checked' : '' }} required>
            <label for="en">English</label>
        </div>
        <div class="icheck-success d-inline">
            <input type="radio" name="lang" id="kh" value="kh" 
                {{ old('lang') == 'kh' ? 'checked' : '' }} required>
            <label for="kh">ភាសាខ្មែរ</label>
        </div>
        @error('lang')
            <br><small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>



      
       

      
        <div class="form-group row mt-2">
            <label for="photo" class="col-sm-3">Photo</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewSingle(event)">
                <div class="mt-2">
                    <img src="" alt="Preview" id="img" class="img-fluid rounded" style="max-width: 150px;">
                </div>
            </div>
        </div>

        {{-- Save & Cancel Buttons --}}
        <x-form.save url="{{ route('user.index') }}" />
    </form>
</div>
@endsection

@section('js')
<script>
function previewSingle(event) {
    let img = document.getElementById('img');
    img.src = URL.createObjectURL(event.target.files[0]);
}

function previewImages(event) {
    let preview = document.getElementById('imagesPreview');
    preview.innerHTML = "";
    Array.from(event.target.files).forEach(file => {
        let img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.classList.add("img-thumbnail");
        img.style.maxWidth = "100px";
        img.style.margin = "5px";
        preview.appendChild(img);
    });
}
</script>
@endsection
