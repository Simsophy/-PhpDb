@extends('layouts.app')

@section('title', 'Create Unit')

@section('page_title', 'Create Units')

@section('content')
<p class="my-1">
    <a href="{{ route('unit.index') }}" class="btn btn-success btn-sm">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</p>

<div class="card mt-2">
    <div class="card-body">
        @component('coms.alert') @endcomponent

        <form action="{{ route('unit.save') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required minlength="3">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mt-3">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Save
                </button>
                <a href="{{ route('unit.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
