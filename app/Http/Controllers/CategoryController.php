<?php

namespace App\Http\Middleware;
namespace App\Http\Controllers;
use \App\Http\Middleware\Translate;
use Illuminate\Http\Request;
use View;
use DB;
use Auth;

require_once app_path('Helpers/functions.php');
class CategoryController extends Controller
{
   public function __construct()
 {
    $this->middleware(function ($request,$next){
            app()->setLocale(Auth::user()->lang);
             return $next($request);
    });
       
        View::share('active', 'category');
    }

    // Show list of categories
 public function index()
{
 
     
        if(!check('category','list')){
         return view ('permissions.no');
       }
          
    

    $categories = DB::table('categories')->where('active', 1)->get();

    return view('categories.index', [
        'categories' => $categories,
        'active' => 'category',
    ]);
}

 
public function save(Request $r)
{
      
    $id = $r->id ?? null;

    $r->validate([
        'name' => 'required|min:3|unique:categories,name' . ($id ? ",$id,id" : ''),
    ]);

    $data = ['name' => $r->name, 'active' => 1];

    if ($id) {
        $updated = DB::table('categories')->where('id', $id)->update($data);
        if ($updated) {
            session()->flash('success', 'Category updated successfully!');
        } else {
            session()->flash('fail', 'Failed to update category.');
        }
    } else {
        $inserted = DB::table('categories')->insert($data);
        if ($inserted) {
            session()->flash('success', 'Category created successfully!');
        } else {
            session()->flash('fail', 'Failed to create category.');
        }
    }

    return redirect()->route('category.index');
}


    // Show create form
    public function create()
    {
       
      if(!check('category','insert')){
         return view ('permissions.no');
       } 
    
        return view('categories.create');
    }

// In your CategoryController.php




    // Soft delete category (set active = 0)
public function delete($id)
{
    
        if(!check('category','delete')){
         return view ('permissions.no');
       }
         
    $category = DB::table('categories')->where('id', $id)->first();
    if (!$category) {
        session()->flash('fail', 'Category not found.');
        return redirect()->route('category.index');
    }
    
    if ($category->active == 0) {
        session()->flash('fail', 'Category is already deleted.');
        return redirect()->route('category.index');
    }

    $x = DB::table('categories')
        ->where('id', $id)
        ->update(['active' => 0]);

    if ($x) {
        session()->flash('success', 'Category deleted successfully.');
    } else {
        session()->flash('fail', 'Failed to delete category.');
    }

    return redirect()->route('category.index');
}


    
    public function edit($id)
{
    
    $cat = DB::table('categories')->where('id', $id)->first();

    if (!$cat) {
        session()->flash('fail', 'Category not found.');
        return redirect()->route('category.index');
    }

    return view('categories.edit', compact('cat'));
}

public function update(Request $r, $id)
{
     if(!check('category','update')){
         return view ('permissions.no');
       } 
    $r->validate([
        'name' => 'required|min:3|unique:categories,name,' . $id,
    ]);

    $updated = DB::table('categories')
        ->where('id', $id)
        ->update([
            'name' => $r->name,
        ]);

    if ($updated) {
        session()->flash('success', 'Update successful!');
    } else {
        // If $updated is 0, it might mean no change made, but still success logically
        session()->flash('info', 'No changes were made.');
    }

    return redirect()->route('category.index');
}


}
