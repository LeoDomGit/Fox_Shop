<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends  BaseCrudController

{
        public function __construct()
    {
        $this->model = Permissions::class;
    }
        protected function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);
    }
    public function index()
    {
        // echo "Here";
        $permissions = Permissions::all();
        return Inertia::render('Permissions/Index', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        
    }

 public function destroy(Permissions $permissions,$id)
    {
        $role  = Permissions::find($id);
        if(!$role){
            return response()->json(['check'=>false,'msg'=>'Không tìm thấy mã loại người dùng']);
        }
        $role->delete();
        return response()->json(['check'=>true,'data'=>$this->model::all()]);
    }
}
