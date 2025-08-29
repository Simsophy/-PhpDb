@extends('layouts.app')

@section('title', 'Exchange List')
@section('page_title', 'Exchange List')
@section('js') @endsection

@section('content')
<div class="card mt-2">
    <div class="card-body">
        @component('coms.alert') @endcomponent

        {{-- Active Exchanges --}}
        <h4 class="mb-3 text-success">🟢 Active Exchanges</h4>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>USD</th>
                    <th>KHR</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exchange as $ex)
                    <tr>
                        <td>{{ $ex->date }}</td>
                        <td>{{ $ex->usd }}</td>
                        <td>{{ $ex->khr }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Old Exchanges --}}
        <h4 class="mt-5 mb-3 text-secondary">⚪ Old Exchanges</h4>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>USD</th>
                    <th>KHR</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($olds as $old)
                    <tr>
                        <td>
                            {{$old->date }}</td>
                        <td>{{ $old->usd }}</td>
                        <td>{{ $old->khr }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
