<?php
namespace App\Http\Traits\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Carbon\Carbon;

trait FamiliesInfo {

	public function familiesAllInfo($type, $status)
    {
        try {
            return DB::table('families_models')
                    ->select('families_models.*')
                    ->where('families_models.role','=','Head')
                    ->where('families_models.status','=',decrypt($status))
                    ->where('families_models.category','=',decrypt($type))
                    ->orderBy('hfId','ASC')
                    ->get();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}