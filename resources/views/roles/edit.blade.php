@extends('layouts.app')

@section('title', 'Edit Role')
@section('page_title', 'Edit Role')

@section('content')
<p class="my-2">
    <a href="{{ route('role.index') }}" class="btn btn-success btn-sm">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</p>

<div class="card">
    <div class="card-body">
        @component('coms.alert')@endcomponent

<div class="form-group mt-2">
   
   
   <x-form.input 
    name="name" 
    title="Name" 
    required="required" 
    value="{{ old('name', $role->name) }}" 
    row="col"
/>

</div>


        <!-- Update Form -->
        <form action="{{ route('role.update', $role->id) }}" method="POST">
            @csrf
            @method('PATCH')
          
<x-form.save url="{{ route('role.index') }}" />
</form>

        <!-- Delete Form -->
        <form action="{{ route('role.destroy', $role->id) }}" method="POST" class="mt-2" 
              onsubmit="return confirm('Are you sure you want to delete this role?');">
            @csrf
           
        </form>
    </div>
</div>
@endsection
