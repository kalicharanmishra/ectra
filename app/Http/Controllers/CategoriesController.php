<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoriesController;
use App\Models\Categories;

class CategoriesController extends Controller  
    
{
    public function index()
    {
       $list = Categories::get();
        $active_menu = "CategoryManagement";
        $active_submenu = "CustomerList";
        return view('admin.Categories.categorieList', compact('list','active_menu','active_submenu'));
    }


    public function add()
    {
      $active_menu = "CategoryManagement";
      $active_submenu = "CustomerList";
      return view('admin.Categories.Addcategorie', compact('active_menu','active_submenu'));
    }


    public function store(Request $request)
    {
        $this->validate($request,[
        'title' => 'required'
        ]);


        $dataInsert = new Categories;
        $dataInsert->title = $request->title;
        if ($dataInsert->save()) {
        return redirect()->route('categories.index');
        }else{
        return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
      $edit = Categories::find($id);
      return view('admin.Categories.editCategorie',compact('edit'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'title' => 'required'
        ]);
        $update =  Categories::find($id);
        $update->title = $request->title;
        if ($update->save()) {
        return redirect()->route('categories.index');
        }else{
        return redirect()->back();
        }
    }


    public function changeStatus(Request $request, $status,$id)
    {
        //echo $status; die;
        $user = Categories::find($id);
        $user->status = $status;
        $user->save();
        return redirect()->back();
    }


    public function delete($id)
    {
        $dataDelete = Categories::where('id', $id)->delete();
        return redirect()->route('categories.index');
    }
}