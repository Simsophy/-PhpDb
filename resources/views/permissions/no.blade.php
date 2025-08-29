@extends('layouts.app')

@section('title', 'Warning')

@section('css')
<!-- Add custom CSS here if needed -->
@endsection

@section('page_title', 'Warning') {{-- fixed typo here --}}

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="text-center text-danger">You don't have permission to access</h3> 
        </div>
    </div>
@endsection
