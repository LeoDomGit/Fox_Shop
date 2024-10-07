<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\createUser;
use Inertia\Inertia;

class UserController extends BaseCrudController
{
    protected $model;
    public function __construct(){
        $this->model =  User::class;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->model::with('roles')->get();
        $roles= Roles::all();   
        return Inertia::render('User/Index',['roles'=>$roles,'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'idRole'=>'required|exists:roles,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['check'=>false,'msg'=>$validator->errors()->first()]);
        }
        $data = $request->all();
        $password = random_int(10000, 99999);
        $data['password'] = Hash::make($password);
        User::create($data);
        $data = [
            'email' => $request->email,
            'password' => $password,
        ];
        Mail::to($request->email)->send(new createUser($data));
        $users = $this->model::with('roles')->get();
        return response()->json(['check' => true,'data'=>$users]);
    }
    /**
     * Display the specified resource.
     */
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'email'=>'email|unique:users,email',
            'idRole'=>'exists:roles,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['check'=>false,'msg'=>$validator->errors()->first()]);
        }
        $data= $request->all();
        if($request->has('status')){
            $old = User::find($id)->value('status');
            if($old==0){
                $new=1;
            }else{
                $new=0;
            }
        $data['status']=$new;
        }
        User::findOrFail($id)->update($data);
        $users = User::with('roles')->get();
        return response()->json(['check'=> true,'data'=>$users]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($identifier)
    {
      User::where('id',$identifier)->delete();
      $data= $this->model::with('roles')->get();
      return response()->json(['check'=>true,'data'=> $data],200);

    }
}
