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
    public function getUsers(){
        $users = DB::connection('mysql')
        ->select("Select * from tbl_user");
        return response()->json($users, 200);
    }
}