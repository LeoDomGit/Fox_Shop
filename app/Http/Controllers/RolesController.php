<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolesController extends BaseCrudController
{

    public function __construct()
    {
        $this->model = Roles::class;
    }
        /**
     * Display a listing of the resource.
     */

    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles= Roles::all();
        return Inertia::render('Roles/Index', ['roles'=>$roles]);
        
    }

    public function create()
    {
        
    }
    public function show(Roles $roles)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roles $roles)
    {
    
    }
    public function destroy(Roles $roles,$id)
    {
        $role  = Roles::find($id);
        if(!$role){
            return response()->json(['check'=>false,'msg'=>'Không tìm thấy mã loại người dùng']);
        }
        $role->delete();
        return response()->json(['check'=>true,'data'=>$this->model::all()]);
    }
}
