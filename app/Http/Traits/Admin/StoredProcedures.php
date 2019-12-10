<?php
namespace App\Http\Traits\Admin;

use Illuminate\Http\Request;
use DB;

trait StoredProcedures {

	public function sPocDepCount($hfid,$type,$status,$param)
    {
        try {
            return DB::select('CALL countDependents(?,?,?,?)',array(decrypt($hfid),decrypt($type),decrypt($status),$param));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function sPocServiceConcern($hfid,$type,$prType,$status)
    {
        try {
            return DB::select('CALL getServicesAndConserns(?,?,?,?)',array(decrypt($hfid),decrypt($type),decrypt($prType),decrypt($status)));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function sPocAllServiceConcern($hfid,$type,$serv)
    {
        try {
            return DB::select('CALL getAllServiceConcerns(?,?,?)',array(decrypt($hfid),decrypt($type),decrypt($serv)));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}