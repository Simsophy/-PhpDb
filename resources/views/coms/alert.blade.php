@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        &times;
    </button>
    {{ session('success') }}
</div>
@endif

@if(Session::has('fail'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        &times;
    </button>
    {{ session('fail') }}
</div>
@endif