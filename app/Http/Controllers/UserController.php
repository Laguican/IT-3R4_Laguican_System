<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function addUsers(){

        $rules = [
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ];

        $this->validate($this->request,$rules);

        $users = new User;

        $users->username = $this->username;
        $users->password = $this->password;

        $users->save();
        return response()->json($users,200);
    }

    //update users

    public function updateUsers($id){
        $rules = [
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ];

        $this->validate($this->request,$rules);

        $user = User::find($id);

        if ($user == null)return response()->json('User not found', 404);

        $user->username = $this->request->username;
        $user->password = $this->request->password;

        $user->save();

        return response()->json($user,200);
    }

    // delete existing user
    
    public function deleteUser($id){
        $user= User::find($id);

        if ($user == null)return response()->json('user not fount',404);
        
        $user->delete();

        return response()->json('User Deleted',200);
    }





}