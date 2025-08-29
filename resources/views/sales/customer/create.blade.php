@extends('layouts.app')

@section('title', 'Create Customery')

@section('page_title', 'Create Customer')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
@endsection
@section('content')

<p class="my-1">
    <a href="{{ route('category.index') }}" class="btn btn-success btn-sm">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</p>

<div class="card mt-2">
    <div class="card-body">
            <!-- @component('coms.alert')
        @endcomponent   -->
        <form action="{{ route('customer.save') }}" method="POST">
            @csrf

          

    <x-form.input name="name" title="Name" required="required"  />
    <x-form.input name="gender" title="Gender" required="required"   />
    <x-form.input name="phone" title="Phone" required="required" />
    <x-form.input name="address" title="Address" required="required" />
<x-form.save url="{{ route('customer.index') }}" />
    

</form>
    </div>
</div>
@endsection
@section('js')


 
@endsection