@extends('layouts.app')

@section('title', 'customers')
@section('page_title', 'Customers')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.jqueryui.min.css" integrity="sha512-x2AeaPQ8YOMtmWeicVYULhggwMf73vuodGL7GwzRyrPDjOUSABKU7Rw9c3WNFRua9/BvX/ED1IK3VTSsISF6TQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<p class="my-1">
    <a href="{{ route('customer.create') }}" class="btn btn-success btn-sm">
        <i class="fa fa-plus-circle"></i> Create
    </a>
</p>
<div class="card">
    <div class="card-body">
        @component('coms.alert')
        @endcomponent

        <table class="table table-bordered table-sm" id="dataTable">
            
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" 
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap.min.js" integrity="sha512-F0E+jKGaUC90odiinxkfeS3zm9uUT1/lpusNtgXboaMdA3QFMUez0pBmAeXGXtGxoGZg3bLmrkSkbK1quua4/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('customer.index') }}", // ✅ use Laravel route helper
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'gender', name: 'gender'},
            {data: 'phone', name: 'phone'},
            {data: 'address', name: 'address'},
             {data: 'action', name: 'action', }
        ]
    });
});
</script>
@endsection
