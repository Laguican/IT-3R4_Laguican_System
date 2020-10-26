<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Traits\ApiResponser;
use DB;
Class UserController extends Controller {
    use ApiResponser;

    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }


    //Show all users
    public function getUsers(){
        $users = DB::connection('mysql')
        ->select("Select * from tbl_user");
        return response()->json($users, 200);
    }



    //search user
    public function getUser($id){
        $user= User::find($id);
        if($user == null) return response()->json('User not found', 404);
        return response()->json($user,200);
    }


    // new user create
    public function addUsers(Request $request){

        $rules = [
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ];

        $this->validate($request,$rules);

        $users =User::create($request->all());

        
        return $this->successResponse($users,Response::HTTP_CREATED);
    }

    //update users

    public function updateUsers(Request $request,$id){
        $rules = [
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ];

        $this->validate($request,$rules);

        $user = User::find($id);

        if ($user == null)return response()->json('User not found', 404);

        $user->fill($request->all());

        $user->save();

        print ("user Updated");

        return $this->successResponse($user);
    }

    // delete existing user
    
    public function deleteUsers($id){
        User::findOrFail($id)->delete();

        return response()->json('User Deleted Successfully', 200);
    }





}