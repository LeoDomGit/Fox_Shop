<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class BrandController extends BaseCrudController
{
    public function __construct(){
        $this->model= Brand::class;
    }
    public function index()
    {
        $brands=Brand::all();
        return Inertia::render('Brand/Index', ['brands' => $brands]);
    }
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $data=$validated;
        $data['slug']=Str::slug($validated['name']);
        $this->model::create($data);
        return response()->json(['check'=>true,'data'=>$this->model::all()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
         $category  = Brand::find($id);
        if(!$category){
            return response()->json(['check'=>false,'msg'=>'Không tìm thấy mã thương hiệu']);
        }
        Brand::where('id',$id)->delete();
        // Brand::find($id)->delete();
        return response()->json(['check'=>true,'data'=>$this->model::all()]);
    }
}
