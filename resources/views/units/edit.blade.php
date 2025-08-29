@extends('layouts.app')

@section('title')
Edit Unit
@endsection

@section('page_title')
Edit Unit
@endsection

@section('content')
<p class="my-1">
    <a href="{{ route('unit.index') }}" class="btn btn-success btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</p>

<div class="card">
    <div class="card-body">
        @component('coms.alert')
        @endcomponent

        <form action="{{ route('unit.update', $unit->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Unit Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $unit->name) }}">
            </div>
            <button class="btn btn-primary btn-sm mt-2">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
</div>
@endsection
