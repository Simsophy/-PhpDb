@extends('layouts.app')

@section('title', 'Create Role')
@section('content')
<div class="card">
    <div class="card-body">

        {{-- Single form only --}}
        <form action="{{ route('role.store') }}" method="POST">
            @csrf {{-- CSRF token is required for POST requests --}}

        <x-form.input 
    name="name" 
    title="Name" 
    required="required" 
    
    row="col" 
/>

<x-form.save url="{{ route('role.index') }}" />
</form>

           
        </form>

    </div>
</div>
@endsection
