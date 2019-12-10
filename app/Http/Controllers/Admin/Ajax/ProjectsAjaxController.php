<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\MainTraits;
use App\Http\Traits\DBFieldValidator;
use DB;

class ProjectsAjaxController extends Controller
{
    use MainTraits, DBFieldValidator;

    public $next = '';
	public $count = 0;

	public function hfIdofHead(Request $request){
	  	# to find head as same hfid,if yes,then disable the Head in role DD
	  	$hfid = $this->getHFID($request->type).$request->hfid;
	  	$next = 'HeadId';   
	  	$count = DB::table('tbl_families_personals')->select('id')->where('status','=',1)->where('hfid','=',$hfid)->where('role','=','Head')->where('fam_category','=',$request->type)->count();
	  	return view('admin.ajax_pages.projectAjaxData')->with('count',$count)->with('next',$next);
	}

	public function isMobileExist(Request $request){
    	# to find head as same hfid,if yes,then disable the Head in role DD
    	$next = $request->next;
        $count = $this->find_data('tbl_families_personals',$request->field,'fam_category',$request->type,$request->hfid);
    	return view('admin.ajax_pages.projectAjaxData')->with('count',$count)->with('next',$next)->with('btn',$request->btn);
    }

    public function appendHSCCData(Request $request){
        // to find head as same hfid,if yes,then disable the Head in role DD
        $next = 'HSCCFamDestroy';
        $post = DB::table('families_models')->select('*')->where('familycategory','=',$request->type)->get();
        return view('admin.ajax_pages.projectAjaxData')->with('post',$post)->with('next',$next);
    }

    public function serachDataExists(Request $request){
        // to find head as same hfid,if yes,then disable the Head in role DD
        $next = 'inst_find';
        $count = $this->find_data('tbl_institutions_infos','id','location',$request->id,$request->value);
        $post = DB::table('tbl_institutions_infos')->select('*')->where('id','=',$request->value)->where('location','=',$request->id)->get();
        return view('admin.ajax_pages.projectAjaxData')->with('post',$post)->with('next',$next)->with('count',$count);
    }

    public function getDocCard(Request $request){
        // to find head as same hfid,if yes,then disable the Head in role DD
        $next = 'findCard';
        return view('admin.ajax_pages.projectAjaxData')->with('value',$request->value)->with('value',$request->value);
    }

    public function serachCity(Request $request){
        // to find head as same hfid,if yes,then disable the Head in role DD
        $next = 'city';
        $count = DB::table('tbl_city')->select('id')->where('id','=',$request->value)->count();
        $city = DB::table('tbl_state')
                    ->join('tbl_district','tbl_district.state_id','=','tbl_state.id')
                    ->join('tbl_city','tbl_city.dist_id','=','tbl_district.id')
                    ->join('tbl_pincode','tbl_pincode.city_id','=','tbl_city.id')
                    ->select('tbl_state.state_name',
                            'tbl_district.dist_name',
                            'tbl_city.city_name',
                            'tbl_pincode.pincode')
                    ->where('city_name','=',$request->val2)
                    ->get();
        return view('admin.ajax_pages.projectAjaxData')
                    ->with('city',$city)->with('next',$next)->with('count',$count);
    }

    public function generalEdu(Request $request){
        try {
            $next = 'generalEdu';
            $post = DB::select( "SELECT 
                tfp.id,tfg.id as stdid,tfg.marks_img,tfg.qualification,tfg.year as edu_year,tfg.course_name,tfg.standard_grade,tfg.stage,tfg.strength,tfg.weakness,tfg.present_status,tfg.performance,
                tfi.id as inst_id,tfi.institution_name,tfi.location,tfi.sector,tfi.institution_category,tfi.street as inst_street,tfi.community_type,tfi.city as inst_city,tfi.district as inst_district,tfi.state as inst_state,tfi.pin_code
                FROM tbl_families_personals tfp
                LEFT JOIN  tbl_general_educations tfg ON tfg.student_id = tfp.id
                LEFT JOIN tbl_institutions_infos tfi ON tfi.id = tfg.college_id
                WHERE tfg.year ='".$request->val."' AND tfp.hfid = '".$request->str2."' AND tfp.id = '".$request->str."' AND tfp.status = ".$request->str3." ");

            return view('admin.ajax_pages.projectAjaxData')->with('post',$post)->with('next',$next); 
        } catch (Exception $e) { return $e->getMessage(); }
    }

    public function spiritualDev(Request $request){
        try {
            # serach based on the max year data
            $next = 'spiritualDev';
            $post = DB::select("SELECT  ta.academic_year,tt.t_year,tha.h_year,
                FLOOR(((tt.tajveed+tt.fiqh+tt.arabic+ta.performance)/400)*100) as madrasa,
                FLOOR(((tha.saum + tha.salah)/200)*100) as huqooq_allah,
                FLOOR(((thi.physical+thi.finance+thi.intellectual)/300)*100) as huqooq_ibaadh
                FROM tbl_families_personals tfp 
                LEFT JOIN  (SELECT * FROM tbl_academics WHERE `academic_year` IN 
                (SELECT max(academic_year) FROM tbl_academics WHERE student_id = ".$request->str." AND YEAR(academic_year) ='".$request->val."' ORDER BY academic_year desc)) ta ON ta.student_id = tfp.id
                LEFT JOIN  (SELECT * FROM tbl_tarbiyyah WHERE `t_year` IN 
                (SELECT max(t_year) FROM tbl_tarbiyyah WHERE student_id = ".$request->str." AND YEAR(t_year) ='".$request->val."' ORDER BY t_year)) tt ON tt.student_id = tfp.id
                LEFT JOIN  (SELECT * FROM tbl_huqooq_allah WHERE `h_year` IN 
                (SELECT max(h_year) FROM tbl_huqooq_allah WHERE person_id = ".$request->str." AND YEAR(h_year) ='".$request->val."' ORDER BY h_year )) tha ON tha.person_id = tfp.id
                LEFT JOIN  (SELECT * FROM tbl_huqooq_ibaadh WHERE `ibaadh_year` IN 
                (SELECT max(ibaadh_year) FROM tbl_huqooq_ibaadh WHERE person_id = '".$request->str."' AND YEAR(ibaadh_year) ='".$request->val."' ORDER BY ibaadh_year)) thi ON thi.person_id = tfp.id  ");
            // dd($post);
            return view('admin.ajax_pages.projectAjaxData')->with('post',$post)->with('next',$next); 
        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function lifeSkillsEval(Request $request){
    	try {

            $next = 'lifeSkillsEval';
            $post = DB::select("SELECT  tle.id as lifeskill_id,tle.servaying_feasibility,tle.networking,tle.managing,tle.leadership,tle.communication,tle.organising,tle.team_player,DATE_FORMAT(tle.lifeskill_year,'%Y-%m') as skill_year
                FROM tbl_families_personals tfp 
                LEFT JOIN  (SELECT * FROM tbl_lifeskills_eval WHERE `lifeskill_year` IN 
                (SELECT max(lifeskill_year) FROM tbl_lifeskills_eval WHERE person_id = ".$request->str." AND DATE_FORMAT(lifeskill_year,'%Y-%m') = '".$request->val."' AND status = ".$request->str3.")) 
                tle ON tle.person_id = tfp.id ");
            
            return view('admin.ajax_pages.projectAjaxData')->with('post',$post)->with('next',$next); 
        } catch (Exception $e) { return $e->getMessage(); }
    }
}