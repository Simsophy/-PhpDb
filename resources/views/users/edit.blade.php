@extends('layouts.app')

@section('title', 'Edit User')
@section('page_title', 'Edit User')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit User: {{ $user->name }}</h3>
    </div>
    <div class="card-body">
       <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div class="form-group mb-3">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Username -->
    <div class="form-group mb-3">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        @error('username')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Email -->
    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Role -->
    <x-form.select
        name="role_id"
        title="Role"
        required="required"
        :data="$roles"
        :selected="$user->role_id"
        option-label="name"
        option-value="id"
        row="col"
    />

    <!-- Language -->
    <div class="form-group mb-3">
        <label for="lang">Language</label>
        <select name="lang" class="form-control" required>
            <option value="en" {{ old('lang', $user->lang) == 'en' ? 'selected' : '' }}>English</option>
            <option value="kh" {{ old('lang', $user->lang) == 'kh' ? 'selected' : '' }}>Khmer</option>
            <option value="cn" {{ old('lang', $user->lang) == 'cn' ? 'selected' : '' }}>Chinese</option>
        </select>
        @error('lang')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Photo -->
    

    <!-- Save & Cancel Buttons -->
    <x-form.save url="{{ route('user.index') }}" />
</form>
 </div>

@endsection



