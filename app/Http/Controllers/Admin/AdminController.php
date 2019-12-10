<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;    
use Illuminate\Http\Request;
use App\AdminModels\UnitModel;
use Carbon\Carbon;
use Session;
use DB;
use Auth;

class AdminController extends Controller
{

	public function __construct(){
		$this->middleware('admin.mid');
	}

    public function index(){
        try {
            // $this->access();            
            $units = UnitModel::all();
            return view('admin.index')->with('units',$units);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    protected function access(){
        // if($role == 'Sudo') {
            // Auth::guard('admin')->user()->role
            echo '<script>acess()</script>';
        // }
    }

    // public function role(){
    //     try {
    //         return view('admin.role');
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

    // public function roleStore(Request $request){
    //         $post = DB::table('roles')->insert(['name'=>$request->name,'created_at' => Carbon::now('Asia/Kolkata')]);
    //         // dd($post);
    // 		return redirect()->route('role_page');
    // }
    
}

