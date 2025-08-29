@extends('layouts.app')

@section('title', 'Permissions')

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('page_title', 'Permissions')

@section('content')
<p class="my-1">
    <a href="{{ route('role.index') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-reply"></i> Back
    </a>
</p>

<div class="card">
    <div class="card-body">
        <h5 class="text-danger">Permission for [{{ $role->name }}]</h5>

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Functions</th>
                    <th>View</th>
                    <th>Insert</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
              @php($i = 1)
@foreach($per_roles as $p)
<tr role-id="{{ $role->id }}" permission-id="{{ $p->permission_id }}" id="{{ $p->id ?? 0 }}">


                        <td>{{ $i++ }}</td>
                        <td>{{ $p->alias }}</td>

                        <!-- View -->
                        <td>
                            <div class="icheck-success">
                                <input type="checkbox"
                                       id="list{{ $p->permission_id }}"
                                       value="{{ $p->list == 1 ? '1' : '0' }}"
                                       onchange="save(this)"
                                       {{ $p->list == 1 ? 'checked' : '' }}>
                                <label for="list{{ $p->permission_id }}"></label>
                            </div>
                        </td>

                        <!-- Insert -->
                        <td>
                            <div class="icheck-success">
                                <input type="checkbox"
                                       id="insert{{ $p->permission_id }}"
                                       value="{{ $p->insert == 1 ? '1' : '0' }}"
                                       onchange="save(this)"
                                       {{ $p->insert == 1 ? 'checked' : '' }}>
                                <label for="insert{{ $p->permission_id }}"></label>
                            </div>
                        </td>

                        <!-- Edit / Update -->
                        <td>
                            <div class="icheck-success">
                                <input type="checkbox"
                                       id="update{{ $p->permission_id }}"
                                       value="{{ $p->update == 1 ? '1' : '0' }}"
                                       onchange="save(this)"
                                       {{ $p->update == 1 ? 'checked' : '' }}>
                                <label for="update{{ $p->permission_id }}"></label>
                            </div>
                        </td>

                        <!-- Delete -->
                        <td>
                            <div class="icheck-success">
                                <input type="checkbox"
                                       id="delete{{ $p->permission_id }}"
                                       value="{{ $p->delete == 1 ? '1' : '0' }}"
                                       onchange="save(this)"
                                       {{ $p->delete == 1 ? 'checked' : '' }}>
                                <label for="delete{{ $p->permission_id }}"></label>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
<script>
function save(obj) {
    // toggle value between 0 and 1
    var val = $(obj).val();
    $(obj).val(val == "1" ? "0" : "1");

    var tr = $(obj).closest('tr');
    var tds = tr.find("div");

    // Correct order: View, Insert, Edit, Delete
    var l = $(tds[0]).children("input").val(); // View
    var i = $(tds[1]).children("input").val(); // Insert
    var u = $(tds[2]).children("input").val(); // Edit
    var d = $(tds[3]).children("input").val(); // Delete
var data = {
    id: tr.attr('id') || null,
    role_id: tr.attr('role-id'),
    permission_id: tr.attr('permission-id'),
    list: l,
    insert: i,
    update: u,
    delete: d
};

$.ajax({
    type: 'POST',
    url: '/permission/save',
    data: data,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
        tr.attr('id', response.id); // update row id after insert
    },
    error: function(xhr) {
        console.error(xhr.responseJSON);
        alert('Save failed: ' + xhr.responseJSON.error);
    }
});
}
</script>
@endsection
