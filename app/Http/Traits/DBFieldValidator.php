<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;

trait DBFieldValidator
{
    /**
     * Finding the database field count.
     *
     * @return count
     */
    protected function find_db_data($model,$field,$req_data){
        try { return DB::table($model)->select($field)->where($field,'=', $req_data)->where('status','=',1)->count(); } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Finding the database field count.
     *
     * @return count
     */
    public function find_field_data($model,$field,$req_data){
        try { 
            return DB::table($model)->select($field)->where('id','=', $req_data)->where('status','=',1)->get(); } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Finding the database field count.
     *
     * @return count
     */
    public function find_tested_data($model,$field,$dbfield,$dbfield2,$req_data,$req_data2){
        // dd($req_data);
        try {  return DB::table($model)->select($field)->where($model.'.'.$dbfield,'=', $req_data)->where($dbfield2,'=', $req_data2)->where('status','=',1)->first(); 
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    protected function find_data($model,$field,$field2,$v2,$v1){
        try { return DB::table($model)->select($field)->where($field,'=', $v1)->where($field2,'=', $v2)->where('status','=',1)->where($field, '!=' , null)->count(); } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function countDependents($hfid,$famType){
        try {
            return DB::table('tbl_families_personals')->select('hfid')
                        ->where('tbl_families_personals.hfid','=',$hfid)
                        ->where('status','=',1)
                        ->where('fam_category','=',$famType)
                        ->count();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function validate_data($request_data,$model,$fields){
        try {
            return DB::table($model)
                ->where($fields->name,'=',$request_data->name)
                ->where($fields->dob,'=',$request_data->dob)
                ->where($fields->email,'=',$request_data->email)
                ->orWhere($fields->mobile,'=',$request_data->mobile)
                ->where('status','=', 1)
                ->count();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function validate_data_mob($request_data,$model,$fields){
        try {
            return DB::table($model)
                ->where($fields->email,'=',$request_data->email)
                ->orWhere($fields->mobile,'=',$request_data->mobile)
                ->count();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function showYear($id,$model,$sel,$field){
        try {
            return DB::table($model)->select($sel)->where($field,'=',decrypt($id))->where('status','=', 1)->orderBy($sel,'DESC')->get();

        } catch (\Exception $e) { return $e->getMessage(); }
    }

    public function showYearMonth($id,$model,$sel,$field){
        try {
            return DB::select("SELECT DISTINCT DATE_FORMAT(".$sel.",'%Y-%m') AS monthYear FROM ".$model." WHERE ".$field." = ".$id." AND status = 1 ORDER BY ".$sel." DESC");

        } catch (\Exception $e) { return $e->getMessage(); }
    }

    public function showDBData($model, $select,  $request, $fields)
    {
        try {
            return DB::table($model)->select('*')
                        ->where($fields->email,'=',$request->email)
                        ->orWhere($fields->mobile,'=',$request->mobile)
                        ->where('status','=', 1)
                        ->get();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertData($request, $model){
        try {
                if(ifAnd($request) == true)
                    return DB::table($model)->insert($request);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
