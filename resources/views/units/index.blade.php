@extends('layouts.app')

@section('title', 'units')
@section('page_title', 'Units')
@section('css')
@endsection
@section('content')
<p class="my-1">
    <a href="{{ route('unit.create') }}" class="btn btn-success btn-sm">
        <i class="fa fa-plus-circle"></i> Create
    </a>
</p>

<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($units as $i => $unit)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $unit->name }}</td>
                <td>
                    <a href="{{ route('unit.edit', $unit->id) }}" class="btn btn-success btn-xs">
                        <i class="fas fa-edit" title="Edit"></i> Edit
                    </a>
                    <a href="{{ route('unit.delete', $unit->id) }}" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('You want to delete?')">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
