@extends('layouts.app')

@section('title')
Edit Category
@endsection

@section('page_title')
Edit Category
@endsection
@section('css')
@endsection
@section('content')
<p class="my-1">
    <a href="{{ route('category.index') }}" class="btn btn-success btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</p>

<div class="card">
    <div class="card-body">
       
<form action="{{ route('category.update', $cat->id) }}" method="POST">
    @csrf
    

    <x-form.input name="name" title="Name" value="{{ old('name', $cat->name) }}" required='required' row="col"/>
    <x-form.input name="email" title="Test Email" type="email" value="{{ old('email', $cat->email ?? '123') }}"disable='disable'  />

    <x-form.save url="{{ route('category.index') }}" />
</form>


    </div>
</div>
@section('js')
@endsection
@endsection
