<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;

require_once app_path('Helpers/functions.php');
class PermissionController extends Controller
{
   
    public function __construct(){
        view::share('active','role');
    }
public function index($id)
{
   $data['role']= DB::table('roles')->find($id);
   $sql=" select tb.id, tb.list,tb.insert,tb.update,tb.delete,permissions.name,permissions.alias,permissions.id as permission_id from permissions left join (select *from role_permissions where role_permissions.role_id={$id}) tb on permissions.id =tb.permission_id order by permissions.id asc";   
   $data['per_roles'] = DB::select($sql);
    return view('permissions.index', $data);
}
public function save(Request $r)
{
    $i = 0;

    $data = [
        'list' => $r->list,
        'insert' => $r->insert,
        'update' => $r->update,
        'delete' => $r->delete,
    ];

    if ($r->id) {
        // update existing pivot row by its actual id
        DB::table('role_permissions')
            ->where('id', $r->id) // ✅ use the pivot row id
            ->update($data);
        $i = $r->id;
    } else {
        // insert new row
        $data['role_id'] = $r->role_id;
        $data['permission_id'] = $r->permission_id;

        $i = DB::table('role_permissions')->insertGetId($data);
    }

    return response()->json($i); // return JSON for AJAX
}

  

}
