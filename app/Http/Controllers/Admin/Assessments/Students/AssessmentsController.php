<?php 
namespace App\Http\Controllers\Admin\Assessments\Students;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Http\Traits\MainTraits;
use App\Http\Traits\DBFieldValidator;
use DB;
use Session;
use Carbon\Carbon;
use Response;

class AssessmentsController extends MainController
{
	use MainTraits,DBFieldValidator;
	
	
	# storing assessments details...
    public function storeSpiritual(Request $request)
    {
        try { 
        	if(decrypt($request->formid) == 'lifeSkillModal'){
        		# to store and update the life skills evaluation information
        		$ls = ($this->lifeSkillsInfo($request,'insert')) ? 'success' : 'error';
	            $msg = 'Life Skills Evaluation';
        	} else{
        		# to store and update the madrasa academi information
	           	$ai = ($this->academiInfo($request,'insert')) ? 'success' : 'error';
	        	# to store and update the madrasa Tarbiyyah/ Practice information
	           	$ti = ($this->tarbiyyahInfo($request,'insert')) ? 'success' : 'error';
	        	# to store and update the Huqooq-Allah information
	            $ha = ($this->huqooqAllahInfo($request,'insert')) ? 'success' : 'error';
	        	# to store and update the Huqooq-Ul-Ibaadh information
	            $hi = ($this->huqooqIbaadhInfo($request,'insert')) ? 'success' : 'error';
	            # sending message
	            $msg = 'Spiritual Development';
        	}
        	
            return redirect()->back()->with('success',$msg.' Information Added Successfully');

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function lifeSkillsInfo($request,$action)
    {
        try {
 
        	# calling SPoc to store/ update the madrasa academi information
        	if($action == 'insert'){
        		return DB::table('tbl_lifeskills_eval')->insert([
    					'person_id' => decrypt($request->id),
    					'servaying_feasibility' => $request->servaying,
    					'networking' => $request->networking,
    					'managing' => $request->managing,
    					'leadership' => $request->leadership,
    					'communication' => $request->communication,
    					'organising' => $request->organising,
    					'team_player' => $request->team_player,
    					'lifeskill_year' => $this->getInDate($request->sp_year),
    					'status' => decrypt($request->status),
    					'hfid' => decrypt($request->hfid),
    					'type' => decrypt($request->type),
    					'created_at' => Carbon::now('Asia/Kolkata') ]);
        	}else{
        		return DB::table('tbl_lifeskills_eval')
        				->where(['person_id' => decrypt($request->id),'hfid' => decrypt($request->hfid)])
        				->update([ 'physical' => $request->physical,
	    					'finance' => $request->finance,
	    					'intellectual' => $request->intellectual,
	    					'ibaadh_year' => $request->sp_year,
	    					'updated_at' => Carbon::now('Asia/Kolkata') ]);
        	}

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function huqooqIbaadhInfo($request,$action)
    {
        try {
 
        	# calling SPoc to store/ update the madrasa academi information
        	if($action == 'insert'){
        		return DB::table('tbl_huqooq_ibaadh')->insert([
    					'spiritual_id' => decrypt($request->ibadh_id),
    					'person_id' => decrypt($request->id),
    					'physical' => $request->physical,
    					'finance' => $request->finance,
    					'intellectual' => $request->intellectual,
    					'ibaadh_year' => $this->getInDate($request->sp_year),
    					'status' => decrypt($request->status),
    					'hfid' => decrypt($request->hfid),
    					'type' => decrypt($request->type),
    					'created_at' => Carbon::now('Asia/Kolkata') ]);
        	}else{
        		return DB::table('tbl_huqooq_ibaadh')
        				->where(['person_id' => decrypt($request->id),'hfid' => decrypt($request->hfid)])
        				->update([ 'physical' => $request->physical,
	    					'finance' => $request->finance,
	    					'intellectual' => $request->intellectual,
	    					'ibaadh_year' => $request->sp_year,
	    					'updated_at' => Carbon::now('Asia/Kolkata') ]);
        	}

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function huqooqAllahInfo($request,$action)
    {
        try {
 
        	# calling SPoc to store/ update the madrasa academi information
        	if($action == 'insert'){
        		return DB::table('tbl_huqooq_allah')->insert([
    					'spiritual_id' => decrypt($request->huqooq_id),
    					'salah' => $request->salah,
    					'saum' => $request->saum,
    					'zakath' => $request->zakath,
    					'person_id' => decrypt($request->id),
    					'h_year' => $this->getInDate($request->sp_year),
    					'status' => decrypt($request->status),
    					'type' => decrypt($request->type),
    					'hfid' => decrypt($request->hfid),
    					'created_at' => Carbon::now('Asia/Kolkata') ]);
        	}else{
        		return DB::table('tbl_huqooq_allah')
        				->where(['person_id' => $request->id,'hfid' => $request->hfid])
        				->update([ 'salah' => $request->salah,
	    					'saum' => $request->saum,
	    					'zakath' => $request->zakath,
	    					'h_year' => $request->sp_year,
	    					'updated_at' => Carbon::now('Asia/Kolkata') ]);
        	}

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function academiInfo($request,$action)
    {
        try {
        	# calling SPoc to store/ update the madrasa academi information
        	return DB::select('CALL spAcademiInfo(?,?,?,?,?,?,?,?,?)', $this->paramAcademi($request,$action));

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function tarbiyyahInfo($request,$action)
    {
        try {
        	# calling SPoc to store/ update the madrasa academi information
        	return DB::select('CALL spTarbiyyahInfo(?,?,?,?,?,?,?,?,?,?)', $this->paramTarbiyyah($request,$action));

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function paramAcademi($request,$action)
    {
        try { return array(decrypt($request->academi_id),decrypt($request->id),$request->m_grade,$request->m_performance,$request->sp_year,decrypt($request->hfid),decrypt($request->type),decrypt($request->status),$action);

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function paramTarbiyyah($request,$action)
    {
        try { return array(decrypt($request->academi_id),decrypt($request->id),$request->tajveed,$request->arabic,$request->fiqh,$request->sp_year,decrypt($request->type),decrypt($request->hfid),decrypt($request->status),$action);

        } catch (Exception $e) { return $e->getMessage(); }
    }

}