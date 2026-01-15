<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

function check($permission_name, $action)
{
    $role_id = Auth::user()->role_id;
    $q = DB::table('role_permissions')
        ->join('permissions', 'role_permissions.permission_id', 'permissions.id')
        ->select('role_permissions.list', 'role_permissions.insert', 'role_permissions.update', 'role_permissions.delete')
        ->where('role_permissions.role_id', $role_id)
        ->where('permissions.name', $permission_name);
    switch($action)
    {
        case 'insert':
            $q = $q->where('role_permissions.insert', 1);
            break;
        case 'update':
            $q = $q->where('role_permissions.update', 1);
            break;
        case 'delete':
            $q = $q->where('role_permissions.delete', 1);
            break;
        case 'list':
            $q = $q->where('role_permissions.list', 1);
            break;
        default:
            break;
    }
    return ($q->count() > 0);
}


function page() {
    $page = @$_GET['page'];
    if (!$page) {
        $page = 1;
    }
    return config('app.row') * ($page - 1) + 1;
}

function to_select($data, $name, $id = '') {
    $select = "<select class='form-control' name='$name' id='$name'>";

    foreach ($data as $d) {
        $selected = $d->id == $id ? "selected" : "";
        $select .= "<option value='{$d->id}' $selected>{$d->name}</option>";
    }

    $select .= "</select>";
    return $select;
}
