@extends('layouts.app')

@section('title', 'Create Category')
@section('page_title', 'Create Category')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
@endsection

@section('content')
<p class="my-1">
    <a href="{{ route('category.index') }}" class="btn btn-success btn-sm">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</p>

<div class="card mt-2">
    <div class="card-body">
     <form action="{{ route('category.save') }}" method="POST">
    @csrf

 <x-form.input name="name" title="Name" row="col" />


<x-form.save url="{{ route('category.index') }}" />
</form>





        
    </div>
</div>
@endsection
