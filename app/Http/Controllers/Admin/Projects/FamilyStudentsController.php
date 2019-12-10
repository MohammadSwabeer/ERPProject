<?php

namespace App\Http\Controllers\Admin\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Projects\FamiliesController;
use DB;
use Session;
use Carbon\Carbon;
use Crypt;
use App\Http\Traits\Admin\AssessmentsTrait;
use App\AdminModels\studentevaluation;

class FamilyStudentsController extends FamiliesController
{
  use AssessmentsTrait;
    
    public function viewFamiliesStudents($type,$prType,$page,$status,$person)
    {   
        // dd(decrypt($type));
        $post = $this->familiesStudentsProfiles(decrypt($type),decrypt($status));
        // dd($post);
        return view('admin.Projects.StudentsInfo.StudentsLinkData.viewStudentsInformation')->with('post',$post)->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person));
    }

    public function familiesStudentsProfiles($type,$status)
    {
      return  DB::table('tbl_families_personals AS tfp')
                ->leftJoin('tbl_familiesfuture_infos AS tfi','tfi.person_id','=','tfp.id')
                ->leftJoin('tbl_general_educations AS tge','tge.student_id','=','tfp.id')
                ->select('tfp.id', 'tfp.fname', 'tfp.lname', 'tfp.hfid', 'tfp.gender', 'tfp.dob',
                        'tfi.occupation_name', 'tfi.goal', 'tge.qualification')
                ->where('tfp.status','=',$status)
                ->where('tfp.fam_category','=',$type)
                ->where('tfi.occupation_name','=','Student')
                ->orderBy('tfp.hfid')
                ->get();
    }



    public function showStudentsProfile($id,$hfid,$type,$prType,$page,$status,$person) { 
      try {
        $fam = DB::select('call fam_details(?,?,?,?)',array(decrypt($id),decrypt($status),decrypt($type),'id'));
        $post = $this->getFamiliesStudentProfiles(decrypt($id),decrypt($type),decrypt($status),'id');
        $add = $this->findFamiliesAddress(decrypt($hfid),decrypt($type),decrypt($status));
        $inst = $this->inst_details(decrypt($status));
      	$educations = $this->showStudentEducation(decrypt($id),decrypt($type));
        $sdYear = $this->showYearMonth(decrypt($id),'tbl_academics','academic_year','student_id');
        $lsYear = $this->showYearMonth(decrypt($id),'tbl_lifeskills_eval','lifeskill_year','person_id');
        // dd($lsYear);
        $years = $this->showYear($id,'tbl_general_educations','year','student_id');
        $sids = $this->SpiritualId();
        $mids = $this->MadrasaId();

        return view('admin.Projects.StudentsInfo.StudentsLinkData.viewStudentsProfilesInfo')->with('post',$post)->with('inst',$inst)->with('add',$add)->with('sids',$sids)->with('mids',$mids)->with('stdid', decrypt($id))->with('hfid', decrypt($hfid))->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person))->with('fam',$fam)->with('years',$years)->with('lsYear',$lsYear)->with('sdYear',$sdYear)->with('educations',$educations);

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function getFamiliesStudentProfiles($id,$type,$status,$param){
        try {
            return DB::select("SELECT tfp.*,
                tfg.id as stdid,tfg.qualification,tfg.year as edu_year,tfg.course_name,tfg.standard_grade,tfg.stage,tfg.strength,tfg.weakness,tfg.present_status,tfg.performance,tfg.marks_img,
                tfi.id as inst_id,tfi.institution_name,tfi.location,tfi.sector,tfi.institution_category,tfi.street as inst_street,tfi.community_type,tfi.city as inst_city,tfi.district as inst_district,tfi.state as inst_state,tfi.pin_code,
                tff.occupation_name,tff.hobbies,tff.goal,
                tfr.description as feedback,
                tle.id as lifeskill_id,tle.servaying_feasibility,tle.networking,tle.managing,tle.leadership,tle.communication,tle.organising,tle.team_player,
                FLOOR(((tt.tajveed+tt.fiqh+tt.arabic+ta.performance)/400)*100) as madrasa,ta.academic_year,ta.grade,
                tha.h_year,ta.id AS rid,tha.id AS hid,FLOOR(((tha.saum + tha.salah)/200)*100) as huqooq_allah,
                FLOOR(((thi.physical+thi.finance+thi.intellectual)/300)*100) as huqooq_ibaadh
                FROM tbl_families_personals tfp 
                LEFT JOIN (SELECT * FROM tbl_familiesfuture_infos WHERE `status` IN 
                (SELECT status FROM tbl_familiesfuture_infos where status = 1)) 
                tff ON tff.person_id = tfp.id
                LEFT JOIN  (SELECT * FROM tbl_general_educations WHERE `year` IN 
                (SELECT max(year) FROM tbl_general_educations WHERE student_id = ".$id." AND fam_category = '".$type."' AND status = ".$status.")) 
                tfg ON tfg.student_id = tfp.id
                LEFT JOIN  (SELECT * FROM tbl_academics WHERE `academic_year` IN 
                (SELECT max(academic_year) FROM tbl_academics WHERE student_id = ".$id." AND type = '".$type."' AND status = ".$status.")) 
                ta ON ta.student_id = tfp.id
                LEFT JOIN  (SELECT * FROM tbl_tarbiyyah WHERE `t_year` IN 
                (SELECT max(t_year) FROM tbl_tarbiyyah WHERE student_id = ".$id." AND type = '".$type."' AND status = ".$status.")) 
                tt ON tt.student_id = tfp.id
                LEFT JOIN  (SELECT * FROM tbl_huqooq_allah WHERE `h_year` IN 
                (SELECT max(h_year) FROM tbl_huqooq_allah WHERE person_id = ".$id." AND type = '".$type."' AND status = ".$status.")) 
                tha ON tha.person_id = tfp.id
                LEFT JOIN  (SELECT * FROM tbl_huqooq_ibaadh WHERE `ibaadh_year` IN 
                (SELECT max(ibaadh_year) FROM tbl_huqooq_ibaadh WHERE person_id = ".$id." AND type = '".$type."' AND status = ".$status.")) 
                thi ON thi.person_id = tfp.id
                LEFT JOIN  (SELECT * FROM tbl_lifeskills_eval WHERE `lifeskill_year` IN 
                (SELECT max(lifeskill_year) FROM tbl_lifeskills_eval WHERE person_id = ".$id." AND type = '".$type."' AND status = ".$status.")) 
                tle ON tle.person_id = tfp.id
                LEFT JOIN (SELECT * FROM tbl_feedback_remarks WHERE `status` IN 
                (SELECT status FROM tbl_feedback_remarks where status = 1))
                tfr ON tfr.id = tfp.id
                LEFT JOIN tbl_institutions_infos tfi ON tfi.id = tfg.college_id
                WHERE tfp.id = '".$id."'  AND tfp.fam_category = '".$type."' AND tfp.status = ".$status." ");

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function findFamiliesAddress($hfid,$type,$status){
        try {
            return DB::select("SELECT tfa.id as aid,tfa.door_no,tfa.street_area,tfa.belongs_to,tfa.city,tfa.state,tfa.district,tfa.nation,tfa.pincode,tfh.present_door
                FROM tbl_families_personals tfp 
                LEFT JOIN (SELECT * FROM tbl_history_status WHERE `hfid_link` IN 
                (SELECT hfid_link FROM tbl_history_status where status = 1 AND hfid_link = '".$hfid."')) tfh ON tfp.id = tfh.fam_id
                LEFT JOIN (SELECT * FROM tbl_families_address WHERE `hfid_link` IN 
                (SELECT hfid_link FROM tbl_families_address where status = 1 AND hfid_link = '".$hfid."')) tfa ON tfp.id = tfa.person_id
                WHERE tfp.hfid = '".$hfid."' AND tfp.fam_category = '".$type."' AND tfp.status = '".$status."' AND role ='Head' ");

        } catch (Exception $e) { return $e->getMessage(); }
    }

    public function showParticularStudentProfile($id,$type)
    {
    	$post = DB::table('families_models')
                    ->leftJoin('studentevaluations', 'studentevaluations.stdid', '=', 'families_models.id')
                	  // ->leftJoin('tbl_basic_skills', 'tbl_basic_skills.personid', '=', 'families_models.id')
                    ->select('families_models.id as student_id',
                    		'families_models.full_name',
                    		'families_models.gender',
                    		'families_models.hfId',
                    		'families_models.dob',
		                    'families_models.presentFamilyDoor',
		                    'families_models.status',
		                    'families_models.goal',
		                    'families_models.mobile',
                        'families_models.email',
                        'families_models.image',
		                    'families_models.adhar_no',
                        'families_models.hobbies',
                        'families_models.qualification',
                        'families_models.occupation',
                    		'studentevaluations.id as eval_id',
		                    'studentevaluations.stdid',
		                    'studentevaluations.stage as school_type',
		                    'studentevaluations.grade',
		                    'studentevaluations.school_college_name',
		                    'studentevaluations.weakness',
		                    'studentevaluations.strength',
		                    'studentevaluations.performance',
		                    'studentevaluations.madrasa',
		                    'studentevaluations.ibada',
		                    'studentevaluations.practices',
		                    'studentevaluations.year as s_year',
		                    'studentevaluations.eval_status',
		                    'studentevaluations.remark')
		                    // 'tbl_basic_skills.*')
                    ->where('families_models.id','=', decrypt($id))
                    ->where('families_models.status','=',1)
                    ->where('families_models.category','=', decrypt($type))
                    ->orderBy('studentevaluations.year','DESC')
                    ->get();

        return $post;
    }

    public function studentsAllInfo($value,$type,$status,$field)
    {
      try {
          return DB::table('tbl_families_personals')
                    ->leftJoin('tbl_families_address','tbl_families_address.person_id','=','tbl_families_personals.id')
                    ->leftJoin('tbl_familiesfuture_infos','tbl_familiesfuture_infos.person_id','=','tbl_families_personals.id')
                    ->leftJoin('tbl_service_conserns','tbl_service_conserns.person_id','=','tbl_families_personals.id')
                    ->leftJoin('tbl_general_educations','tbl_general_educations.student_id','=','tbl_families_personals.id')
                    ->leftJoin('tbl_madrasa_education','tbl_madrasa_education.stud_id','=','tbl_families_personals.id')
                    ->leftJoin('tbl_tarbiyyah_madrasa','tbl_tarbiyyah_madrasa.person_id','=','tbl_families_personals.id')
                    ->leftJoin('tbl_spiritual_assessments','tbl_spiritual_assessments.stud_id','=','tbl_families_personals.id')
                    ->leftJoin('tbl_institutions_infos','tbl_institutions_infos.id','=','tbl_general_educations.college_id')
                    ->leftJoin('tbl_feedback_remarks','tbl_feedback_remarks.person_id','=','tbl_families_personals.id')
                    ->leftJoin('tbl_lifeskills','tbl_lifeskills.person_id','=','tbl_families_personals.id')
                    ->select('tbl_families_personals.*',
                                'tbl_familiesfuture_infos.occupation_name',
                                'tbl_familiesfuture_infos.hobbies',
                                'tbl_familiesfuture_infos.goal',
                                'tbl_general_educations.qualification as stdid',
                                'tbl_general_educations.qualification',
                                'tbl_general_educations.course_name',
                                'tbl_general_educations.standard_grade',
                                'tbl_general_educations.stage',
                                'tbl_general_educations.strength',
                                'tbl_general_educations.weakness',
                                'tbl_general_educations.present_status',
                                'tbl_general_educations.performance',
                                'tbl_general_educations.present_status',
                                'tbl_general_educations.year as edu_year',
                                'tbl_madrasa_education.stud_id',
                                'tbl_madrasa_education.madrasa_grade',
                                'tbl_madrasa_education.performance as m_performance',
                                'tbl_tarbiyyah_madrasa.person_id as t_id',
                                'tbl_tarbiyyah_madrasa.tajveed',
                                'tbl_tarbiyyah_madrasa.fiqh',
                                'tbl_tarbiyyah_madrasa.arabic',
                                'tbl_spiritual_assessments.salah',
                                'tbl_spiritual_assessments.saum',
                                'tbl_spiritual_assessments.physical',
                                'tbl_spiritual_assessments.finance',
                                'tbl_spiritual_assessments.intellectual',
                                'tbl_service_conserns.description as service_desc',
                                'tbl_lifeskills.surveying',
                                'tbl_lifeskills.networking',
                                'tbl_lifeskills.managing',
                                'tbl_lifeskills.leadership',
                                'tbl_lifeskills.communication',
                                'tbl_lifeskills.organising',
                                'tbl_lifeskills.team_player',
                                'tbl_institutions_infos.institution_name',
                                'tbl_institutions_infos.sector',
                                'tbl_institutions_infos.institution_category',
                                'tbl_institutions_infos.street as inst_street',
                                'tbl_institutions_infos.city as inst_city',
                                'tbl_institutions_infos.district as inst_district',
                                'tbl_institutions_infos.state as inst_state',
                                'tbl_institutions_infos.pin_code',
                                'tbl_feedback_remarks.description as feedback',
                                'tbl_families_address.door_no',
                                'tbl_families_address.street_area',
                                'tbl_families_address.city',
                                'tbl_families_address.state',
                                'tbl_families_address.district',
                                'tbl_families_address.nation',
                                'tbl_families_address.pincode')
                    ->where('tbl_families_personals.'.$field,'=',decrypt($value))
                    ->where('tbl_families_personals.status','=',decrypt($status))
                    ->where('tbl_families_personals.fam_category','=',decrypt($type))
                    ->orderBy('tbl_families_personals.hfid')
                    ->groupBy('tbl_families_personals.id')
                    ->get();
      } catch (Exception $e) {
         return $e->getMessage();
      }
    }

    public function showHSCCFamilyStudentAssessment($id)
    {
    	try {
          $post = $this->showHSCCFamilySingleStudent($id);
          // $uniq = $std->basicData();
          return view('admin.Projects.StudentsInfo.HSCCStudents.ViewStudentAssessments')
                  ->with('post',$post)
                  ->with('years',$years);
      } catch (Exception $e) {
         return $e->getMessage();
      }
    }

    public function showStudentEducation($id,$type) {
      try{
    	   return DB::table('tbl_families_personals AS tfp')
                    ->leftJoin('tbl_general_educations AS tge', 'tge.student_id', '=', 'tfp.id')
                    ->leftJoin('tbl_institutions_infos AS tii', 'tii.id', '=', 'tge.college_id')
                    ->select('tfp.id as stud_id', 'tge.qualification', 'tge.course_name', 'tge.standard_grade', 'tge.stage', 'tge.strength', 'tge.weakness', 'tge.present_status', 'tge.performance', 'tge.present_status', 'tge.year','tii.institution_name','tii.street')
                    ->where(['tfp.id' => $id, 'tfp.status' => 1, 'tfp.fam_category' => $type])
                    ->orderBy('tge.year','DESC')->get();

      } catch (\Exception $e) { return $e->getMessage(); }
    }

    public function showPerformanceChart($id,$hfid,$type,$prType,$page,$status,$person)
    {
        try {
            $getGen = DB::select("SELECT tfp.id,tfp.fname,tfp.lname,tfp.dob,
                tfg.id as stdid,tfg.qualification,tfg.year as edu_year,tfg.course_name,tfg.standard_grade,tfg.stage,tfg.strength,tfg.weakness,tfg.present_status,tfg.performance,
                tfi.id as inst_id,tfi.institution_name,tfi.location,tfi.sector,tfi.institution_category,tfi.street as inst_street,tfi.community_type,tfi.city as inst_city,tfi.district as inst_district,tfi.state as inst_state,tfi.pin_code
                FROM tbl_families_personals tfp
                INNER JOIN tbl_general_educations tfg ON tfg.student_id = tfp.id
                LEFT JOIN tbl_institutions_infos tfi ON tfi.id = tfg.college_id
                WHERE tfp.id = '".decrypt($id)."'  AND tfp.fam_category = '".decrypt($type)."' AND tfp.status = ".decrypt($status)." ORDER BY tfg.year ");

            return view('admin.Projects.StudentsInfo.HSCCStudents.HSCCStudentsAssessmentChart')->with('getGen',$getGen);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    # previously this method was HSCCFamilyStudentsAssessing
    public function addStudentsAssessment($type,$status ='')
    {
        try {
            $post = $this->familiesStudentsProfiles($type,$status);
            return view('admin.Projects.StudentsInfo.StudentsLinkData.StudentAssessments.allStudentsAssessing')
                      ->with('type',$type)
                      ->with('post',$post);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeHSCCFamilyStudentsAssessment(Request $request)
    {
        try {
            $check = DB::table('studentevaluations')
                     ->where('stdid','=',$request->id)
                     ->where('year','=',$request->year)
                     ->count();

             if ($check > 0) {
                 Session::flash('error','This student evaluation details already entered...');
                 return redirect()->route('HSCCFamilyStudentsAssessing');
             }

             $perfomance = round(($request->perfomance/5)*100);

             $madrasa = round(($request->madrasa/3)*100);
             $ibada = round(($request->ibada/3)*100);
             $practices = round(($request->practices/3)*100);

             $remark = round($perfomance) + round($madrasa) + round($ibada) + round($practices);

             // dd($remark/400 *100);
             //inserting students evaluation details...
             $evaluation = new studentevaluation;
             $evaluation->stdid = $request->id;
             $evaluation->school_type=$request->category;
             $evaluation->grade=$request->grade;
             $evaluation->school=$request->school;
             $evaluation->weak=$request->weak;
             $evaluation->strong=$request->strong;
             $evaluation->perfomance=$perfomance;
             $evaluation->madrasa=$madrasa;
             $evaluation->ibada=$ibada;
             $evaluation->practices=$practices;
             $evaluation->year=$request->year;
             $evaluation->remark= round(($remark/400)*100);
             $evaluation->save();

             Session::flash('success','record inserted successfully...');
             return redirect()->route('HSCCFamilyStudentsAssessing');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    # storing assessments details...
    public function addAssessments($id,$hfid,$type,$prType,$page,$status,$person)
    {
        try {
             # to rretieve the families required data 
            
            return view('admin.Projects.StudentsInfo.StudentsLinkData.StudentAssessments.feedStudentEvaluation')->with('id',decrypt($id))->with('hfid',decrypt($hfid))->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    # storing assessments details...
    public function feedAssessments(Request $request)
    {
        try {
          // dd($request->all());
             # to rretieve the families required data 
            DB::table('tbl_spiritual_assessments')
                      ->insert([
                        'stud_id' => $request->id,
                        'salah' => $request->salah,
                        'saum' => $request->saum,
                        'physical' => $request->physical,
                        'finance' => $request->finance,
                        'intellectual' => $request->intellectual,
                        'hfid_link' => $request->hfid,
                        'fam_category' => $request->category,
                        'created_at' => Carbon::now('Asia/Kolkata')
                      ]);

            DB::table('tbl_madrasa_education')
                      ->insert([
                        'stud_id' => $request->id,
                        'madrasa_grade' => $request->madrasa_grade,
                        'performance' => $request->performance,
                        'hfid_link' => $request->hfid,
                        'fam_category' => $request->category,
                        'created_at' => Carbon::now('Asia/Kolkata')
                      ]);

            DB::table('tbl_tarbiyyah_madrasa')
                      ->insert([
                        'person_id' => $request->id,
                        'tajveed' => $request->tajveed,
                        'fiqh' => $request->fiqh,
                        'arabic' => $request->arabic,
                        'hfid_link' => $request->hfid,
                        'fam_category' => $request->category,
                        'created_at' => Carbon::now('Asia/Kolkata')
                      ]);

          DB::table('tbl_lifeskills')
                      ->insert([
                        'person_id' => $request->id,
                        'surveying' => $request->feasibility,
                        'networking' => $request->networking,
                        'managing' => $request->managing,
                        'leadership' => $request->leadership,
                        'communication' => $request->communication,
                        'organising' => $request->organising,
                        'team_player' => $request->team_player,
                        'hfid_link' => $request->hfid,
                        'fam_category' => $request->category,
                        'created_at' => Carbon::now('Asia/Kolkata')
                      ]);
            
            Session::flash('success','Recod inserted Successfully..!');

            return redirect()->route('viewStudentsInfo',[encrypt($request->category),encrypt($request->prType),encrypt($request->page),encrypt($request->status),encrypt($request->personCat)]);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
