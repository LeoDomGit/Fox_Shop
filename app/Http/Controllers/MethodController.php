<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Method;
use Illuminate\Support\Facades\Validator;

class MethodController extends Controller
{
    public function __construct(){
        $this->model = Method::class;
    }
    public function Index(){
        $method = Method::all();
        return Inertia::render('Methods/Index', ['payment'=>$method]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'method' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['check'=>false, 'msg'=>$validator->errors()->first()]);
        }
        $data = [];
        $data['method'] = $request->method;
        $this->model::create($data);
        return response()->json(['check'=>true, 'data'=>$this->model::all()]);
    }
    public function show($id){
        $resulft = $this->model::find($id);
        return Inertia::render('Methods/Edit', ['payments' => $resulft]);
    }
    public function updateMethod(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'method' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['check'=>false, 'msg'=>$validator->errors()->first()]);
        }
        $data = [];
        $data['method'] = $request->method;
        $this->model::find($id)->update($data);
        return response()->json(['check'=>true, 'data'=>$this->model::all()]);
    }

    public function destroy(Method $method)
    {
        $method = $this->model::find($method->id);
        if(!$method){
            return response()->json(['check'=>false,'msg'=>'Không tìm thấy Method']);
        }
        $method->delete();
        return response()->json(['check'=>true,'data'=>$this->model::all()]);
    }
}
