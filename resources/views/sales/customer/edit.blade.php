@extends('layouts.app')

@section('title', 'Edit customer')
@section('page_title', 'Edit customer')

@section('content')
<p class="my-1">
    <a href="{{ route('customer.index') }}" class="btn btn-success btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</p>

<div class="card">
    <div class="card-body">
        @component('coms.alert') @endcomponent
<form action="{{ route('customer.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')

    <x-form.input name="name" title="Name" required="required"  value="{{$customer->name}}"/>
    <x-form.input name="gender" title="Gender" required="required"   value="{{$customer->gender}}" />
    <x-form.input name="phone" title="Phone" required="required"  value="{{$customer->phone}}"/>
    <x-form.input name="address" title="Address" required="required"  value="{{$customer->address}}" />
<x-form.save url="{{ route('customer.index') }}" />
    

</form>


      
    </div>
</div>
@endsection
