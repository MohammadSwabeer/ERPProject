<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use DB;

class RoleController extends Controller
{
    public function role(){
        try {
            return view('admin.role');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function roleStore(Request $request){
            $post = DB::table('roles')->insert(['name'=>$request->name,'created_at' => Carbon::now('Asia/Kolkata')]);
    		return redirect()->route('role_page');    
    }   
}
