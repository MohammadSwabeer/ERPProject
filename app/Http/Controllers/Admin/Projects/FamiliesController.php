<?php
namespace App\Http\Controllers\Admin\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Http\Traits\MainTraits;
use App\Http\Traits\UplaodImage;
use App\Http\Traits\Admin\FamiliesInfo;
use App\Http\Traits\Admin\StoredProcedures;
use App\Http\Traits\DBFieldValidator;
use App\address;
use DB;
use Session;
use Crypt;
use Carbon\Carbon;
use Response;
class FamiliesController extends MainController
{
    use MainTraits, UplaodImage, DBFieldValidator, FamiliesInfo, StoredProcedures;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.Projects.index');
    }


    public function similarFamiliesInfo($type,$prType,$page,$status,$person)
    {
        try {

             # to rretieve the families required data 
            $post = $this->familiesValuableData($type,$status);
            
            return view('admin.Projects.FamiliesInfo.FamiliesDataLink.viewFamilyDetails')->with('post',$post)->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This records includes the info of families all member details of all category
     *
     * @return Data
     */
    public function familiesValuableData($type,$status)
    {
        return DB::table('tbl_families_personals')
                ->leftJoin('tbl_history_status','tbl_history_status.fam_id','=','tbl_families_personals.id')
                ->leftJoin('tbl_familiesfuture_infos','tbl_familiesfuture_infos.person_id','=','tbl_families_personals.id')
                ->leftJoin('tbl_general_educations','tbl_general_educations.student_id','=','tbl_families_personals.id')
                ->select('tbl_families_personals.id',
                        'tbl_families_personals.fname',
                        'tbl_families_personals.lname',
                        'tbl_families_personals.hfid',
                        'tbl_families_personals.mobile',
                        'tbl_families_personals.gender',
                        'tbl_families_personals.dob',
                        'tbl_families_personals.doj',
                        'tbl_history_status.present_door',
                        'tbl_familiesfuture_infos.occupation_name',
                        'tbl_general_educations.qualification')
                ->where('tbl_families_personals.status','=',decrypt($status))
                ->where('tbl_families_personals.fam_category','=',decrypt($type))
                ->where('tbl_families_personals.role','=','Head')
                ->orderBy('tbl_families_personals.hfid')
                ->groupBy('tbl_families_personals.id')
                ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type,$prType,$page,$status,$person,$role)
    {
        $inst = $this->inst_details($status);
        $cities = $this->city_details();

        return view('admin.Projects.FamiliesInfo.HSCCFamilies.addHSCCFamilyDetails')->with('inst',$inst)->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person))->with('role',decrypt($role))->with('cities',$cities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeHSCCFamilyDetails(Request $request)
    {
        try {
            # validation
            // $this->validator_mob_mail($request->all(),'tbl_families_personals');
            // $this->validator_unique_field($request->all(), 'tbl_families_personals','mobile','mobile');
            // $this->validator_unique_field($request->all(), 'tbl_families_personals','mobile','mobile');

            # assigning custom user values
            $hfid =$this->getHFID($request->type).$request->hfid; $pic = $request->adhar_no.$hfid;
            $presentDoor = $this->preg_replaces_field($request->present_door);
            $previousDoor = $this->preg_replaces_field($request->door_no);
            
            # checking for unique user data     
            $check = DB::select('CALL unique_family_check(?,?,?,?,?)',array($hfid,ucfirst($request->fname),ucfirst($request->lname),$request->dob,$request->status));
            # if user data exists then redirecting to previous page
            if(getProper($check,'f_id') > 0)
                return redirect()->back()->withInput()->withError('error','Record Already Exists'); 
            
            # encrypting and getting parameters
            $params = $this->enc_add($request->type, $request->prType, $request->page, $request->status, $request->personCat, $request->role);
            
            # inserting city related shortcut values
            $shortParam = $this->cityShortCutParam($request,'insert');
            $add_city_short = DB::select('CALL cityShortcuts(?,?,?,?,?,?)', $shortParam);

            # image uploads
            $ration_image = ($request->role == 'Head') ? $this->saveImage($request,getImagePath("Doc",$request->type,$request->hfid,"Ration"),'ration_image',$request->hfid,"Ration") : '';
            # uploading ration card image to database table
            $adhar_image = $this->saveImage($request,getImagePath("Doc",$request->type,$request->hfid,"Adhar"),'adhar_image',$request->hfid,"Adhar");
            # uploading family's profile image to database table
            $image = $this->saveImage($request,getImagePath("FamProfile",$request->type),'image',$request->hfid,"Profile");

            # inserting the tbl_families_personals infos
            $insert = $this->insertFamiliesPersonal($request, $image, $adhar_image, $hfid);
            # getting last inserted user id from last inserted record, if not inserted, then redirecting.... 
            $last_id = ($insert) ? DB::select('CALL last_record_id(?,?)',array($hfid,$request->dob,$request->status)) :  $this->redirect_route_param('error','Data not inserted, Somthing error in your data.!','HSCCFamiliesAdd',$params);

            # finding the previous address exists or not, updating/ inserting previous address(tbl_families_address)
            $add = ($request->role == 'Head') ? ifAnd($request->street) ? ($this->find_data('tbl_families_address','person_id','hfid_link',$hfid,getProper($last_id,'lid')) > 0) ? $this->updateAddresses($request,'permanent',getProper($last_id,'lid'),$hfid) : $this->insertAddresses($request,'permanent', getProper($last_id,'lid'),$hfid) : '' : '';

            # inserting process of tbl_service_conserns
            $servCon = $this->iterateServiceConcern(getProper($last_id,'lid'),$hfid,$request->type,$request->services, $request->concerns, $request->services_project, $request->helps_project);

            # user input params of the tbl_familiesfuture_infos table 
            $future = $this->future_param($request,getProper($last_id,'lid'), $hfid,'insert');
            # calling stored procedure for inserting and updating tbl_familiesfuture_infos
            $futures = DB::select('CALL future_info(?,?,?,?,?,?,?)', $future);

            # user input params of the tbl_history_status table 
            $history = ($request->role == 'Head') ? $this->history_param($request, $ration_image,getProper($last_id,'lid'), $hfid,'insert') : '';
            # calling stored procedure for inserting and updating tbl_history_status
            $histories = ($request->role == 'Head') ? DB::select('CALL head_history_info(?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $history) : '';

            # general education informations
            $this->getGeneralEducation($request,getProper($last_id,'lid'),$hfid);

            $action = ($insert) ? 'success' : 'error';
            $msg = ($insert) ? 'Record inserted successfully.!' : 'Record not inserted.!';
            return $this->redirect_route_param($action, $msg, 'HSCCFamiliesAdd', $params);

        } catch (Exception $e) {
            return $e->getMessage(); 
        }
    }

    protected function storeGeneralEducation(Request $request)
    {
        try {
            // dd($request->all());
            $this->getGeneralEducation($request,decrypt($request->id),decrypt($request->hfid));
            
            return redirect()->back()->with('success','General Education Added Successfully');

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function getGeneralEducation($request,$id,$hfid)
    {
        try { 
            # user input params of the tbl_institutions_infos table 
            $institution = $this->inst_param($request);
            # calling stored procedure for inserting and updating tbl_institutions_infos
            $inst_lid = ifAnd($request->institution_name) ? DB::select('CALL institution_info(?,?,?,?,?,?,?,?,?,?,?)', $institution) : '';
            $inst_lid = ifAnd($inst_lid) ? getProper($inst_lid,'ckeck') : '';
            // dd($inst_lid);
            # saving image to the path and returning image name...
            $genimg = $this->getOriginalImage($request,getImagePath('Doc',decrypt($request->type),$hfid,'Marks'), 'marks_img','Doc','Marks', $hfid, $id, 'tbl_general_educations');
            # user input params of the tbl_general_educations table
            $general = $this->general_edu_param($request,$id,$inst_lid ,$hfid, $genimg, 'insert');

            # calling stored procedure for inserting and updating tbl_general_educations
            return DB::select('CALL general_education_info(?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $general);
            
        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function storeImage(Request $request)
    {
        try {

            # getting image name field...
            $img = $this->getImgName(decrypt($request->pic_type));
            $model = $this->getDBModel(decrypt($request->pic_type));
            $hfidField = getHfidFieldName(decrypt($request->pic_type));

            # saving image to the path and returning image name...
            $image = $this->getOriginalImage($request,getImagePath(decrypt($request->str),decrypt($request->type),decrypt($request->hfid),decrypt($request->pic_type)), $img,decrypt($request->str),decrypt($request->pic_type),decrypt($request->hfid),decrypt($request->id), $model);
            
            DB::table($model)->where('status','=',1)->where($hfidField ,'=',decrypt($request->hfid))->where(getPersonIdField(decrypt($request->pic_type)) ,'=',decrypt($request->id))->update([$img => $image]);
                
            return redirect()->back()->with('success', $image.' Image added successfully');
            
        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function getDBModel($type)
    {
        try {
            switch ($type) {
                case 'Ration':
                    return 'tbl_history_status';
                    break;

                case 'Marks':
                    return 'tbl_general_educations';
                    break;
                
                default:
                    return 'tbl_families_personals';
                    break;
            }
            
        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function cityShortCutParam($request,$action)
    {
        try {
            return array($request->city_id,$request->city,$request->district,$request->state,$request->pincode,$action);
            
        } catch (Exception $e) { return $e->getMessage(); }
    }

    public function insertFamiliesPersonal($request,$image,$adhar_image,$hfid)
    {
        try {
            return DB::table('tbl_families_personals')
                  ->insert(['hfid' => $hfid,
                        'fname'=>ucfirst($request->fname),
                        'lname'=>ucfirst($request->lname),
                        'image' => $image,
                        'gender'=>$request->gender,
                        'dob'=>$request->dob,
                        'birth_place'=>ucfirst($request->birth_palce),
                        'nationality'=>$request->nationality,
                        'relegion'=>$request->relegion,
                        'mother_tongue'=> ucfirst($request->mother_tongue),
                        'marital_status'=>$request->marital_status,
                        'adhar_no'=>$request->adhar_no,
                        'adhar_image'=>$adhar_image,
                        'phone'=> $request->phone,
                        'mobile'=> $request->mobile,
                        'email'=> strtolower($request->email),
                        'blood_group'=>$request->blood_group,
                        'living'=> $request->living,
                        'relation'=> $request->relation,
                        'role' => $request->role,
                        'doj' => $request->doj,
                        'fam_category' => $request->type,
                        'user_name' => $request->fname.' '.$request->lname,
                        'password' => ifAnd($request->dob) ? $request->dob : ifAnd($request->adhar_no) ? $request->adhar_no : $hfid,
                        'created_at' => Carbon::now('Asia/Kolkata') ]);
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function enc_add($type,$prType,$page,$status,$personCat,$role){
        try {
            return [encrypt($type),encrypt($prType),encrypt($page),encrypt($status),encrypt($personCat),encrypt($role)];

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function showFamiliesProfiles($id,$hfid,$type,$prType,$page,$status,$person)
    {
        try {

            session(['id' => $id]);           
            # calling getFamiliesProfilesInfo function for Heads Profile & Family's History
            $fam = $this->getFamiliesProfilesInfo($id,$type,$status,'id');
            # calling stotred procedure function to get Sevice and concern details
            $benefit = $this->sPocServiceConcern($hfid,$type,$prType,$status);

            # calling getFamiliesProfilesInfo function for FamilyMembers information
            $post = $this->getFamiliesProfilesInfo($hfid,$type,$status,'hfid');

            # all type of categories counts
            $c=DB::select('CALL getFamiliesAllCounts(?,?,?)',array(decrypt($hfid),decrypt($type),decrypt($status)));
            $dropCount = getProper($this->sPocDepCount($hfid,$type,$status,'drop'),'counts');

            return view('admin.Projects.FamiliesInfo.FamiliesDataLink.viewFamiliesProfile')->with('post',$post)->with('depCount',getProper($c,'Total'))->with('studCount',getProper($c,'students'))->with('empCount',getProper($c,'employees'))->with('maleCount',getProper($c,'males'))->with('femaleCount',getProper($c,'females'))->with('dropCount',$dropCount)->with('benefit',$benefit)->with('fam',$fam)->with('hfid',decrypt($hfid))->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person));

        } catch (Exception $e) { return $e->getMessage(); }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editHSCCFamilyDetails($id,$type,$prType,$page,$status,$person)
    {
        try {
            # calling stored procedure function for edit
            $post = $this->getFamiliesProfilesInfo($id,$type,$status,'id');
            $inst = $this->inst_details($status);
            $cities = $this->city_details();
            $servCon = $this->getBeneficieryConcerns($id,$type,$status,$prType);

            return view('admin.Projects.FamiliesInfo.HSCCFamilies.EditHSCCFamily')->with('post',$post)->with('servCon',$servCon)->with('inst',$inst)->with('cities',$cities)->with('id',decrypt($id))->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person));

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function getFamiliesProfilesInfo($id,$type,$status,$param){
        try {

            return DB::select("SELECT tfp.*,
                tfg.id as stdid,tfg.qualification,tfg.year as edu_year,tfg.course_name,tfg.standard_grade,tfg.stage,tfg.strength,tfg.weakness,tfg.present_status,tfg.performance,tfg.marks_img,
                tfa.door_no,tfa.street_area,tfa.belongs_to,tfa.city,tfa.state,tfa.district,tfa.nation,tfa.pincode,
                tfi.id as inst_id,tfi.institution_name,tfi.location,tfi.sector,tfi.institution_category,tfi.street as inst_street,tfi.community_type,tfi.city as inst_city,tfi.district as inst_district,tfi.state as inst_state,tfi.pin_code,
                tff.occupation_name,tff.hobbies,tff.goal,
                tfr.description as feedback,
                tfh.present_door,tfh.income,tfh.income_source,tfh.ration_no,tfh.ration_image,tfh.familial_relation,tfh.shelter,tfh.self_reliant,tfh.health_status,tfh.reason
                FROM tbl_families_personals tfp 
                LEFT JOIN (SELECT * FROM tbl_history_status WHERE `status` IN 
                (SELECT status FROM tbl_history_status where status = 1)) 
                tfh ON tfp.id = tfh.fam_id
                LEFT JOIN (SELECT * FROM tbl_familiesfuture_infos WHERE `status` IN 
                (SELECT status FROM tbl_familiesfuture_infos where status = 1)) 
                tff ON tff.person_id = tfp.id
                LEFT JOIN tbl_families_address tfa ON tfa.person_id = tfp.id 
                LEFT JOIN  (SELECT * FROM tbl_general_educations WHERE `year` IN 
                (SELECT max(year) FROM tbl_general_educations WHERE student_id = '".decrypt($id)."'))  
                tfg ON tfg.student_id = tfp.id
                LEFT JOIN (SELECT * FROM tbl_feedback_remarks WHERE `status` IN 
                (SELECT status FROM tbl_feedback_remarks where status = 1))
                tfr ON tfr.id = tfp.id
                LEFT JOIN tbl_institutions_infos tfi ON tfi.id = tfg.college_id
                WHERE (CASE WHEN '".$param."' = 'hfid' THEN tfp.hfid = '".decrypt($id)."' ELSE tfp.id = '".decrypt($id)."' END) AND tfp.fam_category = '".decrypt($type)."' AND tfp.status = ".decrypt($status)." ");

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function getBeneficieryConcerns($id, $type, $status, $prType){
        try {

            return DB::select("SELECT tfp.id,tfb.id as service_id,tfb.service_type,tfb.project_type
                FROM tbl_families_personals tfp 
                LEFT JOIN tbl_service_conserns tfb ON tfb.person_id = tfp.id
                WHERE tfp.id = ".decrypt($id)." AND tfp.fam_category = '".decrypt($type)."' AND tfp.status = ".decrypt($status)." AND tfb.project_type = '".decrypt($prType)."' AND tfb.status = ".decrypt($status)."");

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function inst_details($status){
        return DB::table('tbl_institutions_infos')->select('id','institution_name','location')
                        ->where('status','=',$status)->get();
    }

    protected function city_details(){
        return DB::table('tbl_city')->select('id','city_name')->get();
    }

    public function getMonthlyRation($hfid,$type,$prType,$page,$status,$person)
    {
        try {

            return view('admin.Projects.FamiliesInfo.FamiliesDataLink.getMonthlyRationDetails')->with('hfid',$hfid)->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateHSCCFamilyDetails(Request $request)
    {
        try {
            # custom params
            $type = $request->type; $model ='tbl_families_personals';$pic = $request->adhar_no.$request->hfid;
            $model2 = 'tbl_history_status';$hfid = $request->hfid;

            # image updation 
            $image = $this->getOriginalImage($request,$this->getImagePath('FamProfile',$request->type,$request->hfid,'Profile'),'image','FamProfile','Profile',$request->hfid,$request->fam_id,$model);
            # ration_image updation
            $ration_image = $this->getOriginalImage($request,$this->getImagePath('Doc',$request->type,$request->hfid,'Ration'),'ration_image','Doc','Ration',$request->hfid,$request->fam_id,$model2);
            # adhar_image updation
            $adhar_image = $this->getOriginalImage($request,$this->getImagePath('Doc',$request->type,$request->hfid,'Adhar'),'adhar_image','Doc','Adhar',$request->hfid,$request->fam_id,$model);

            # updating tbl_families_personals
            $this->updateFamiliesPersonal($request, $image, $adhar_image, $hfid);

            # finding the previous address exists or not ,updating/ inserting previous address(tbl_families_address)
            ($request->role == 'Head') ? ifAnd($request->street) ? ($this->find_data('tbl_families_address','person_id','hfid_link',$request->hfid,$request->fam_id) > 0) ? $this->updateAddresses($request,'permanent',$request->fam_id,$hfid) : $this->insertAddresses($request,'permanent', $request->fam_id,$hfid) : '' : '';
            
            # getting data from tbl_service_conserns table for testing
            $beneficiary = DB::select('CALL getServiceConcerns(?,?,?)', array($request->fam_id, $request->hfid, $request->status));
            # updating process of tbl_service_conserns
            ifAnd($beneficiary) ? $this->loopServiceConcern($request->servises, $request->concerns, $beneficiary) : '';

            # user input params of the tbl_institutions_infos table 
            $future = $this->future_param($request,$request->fam_id, $hfid,'update');
            # calling stored procedure for inserting and updating tbl_institutions_infos
            $futures = DB::select('CALL future_info(?,?,?,?,?,?,?)', $future);

            # user input params of the tbl_institutions_infos table 
            $history = $this->history_param($request, $ration_image, $request->fam_id, $hfid, 'update');
            # calling stored procedure for inserting and updating tbl_institutions_infos
            $histories = ($request->role == 'Head') ? DB::select('CALL head_history_info(?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $history) : '';

            # user input params of the tbl_institutions_infos table 
            $institution = $this->inst_param($request);
            # calling stored procedure for inserting and updating tbl_institutions_infos
            $inst_last_id = DB::select('CALL institution_info(?,?,?,?,?,?,?,?,?,?,?)', $institution);
            $inst_lid = ifAnd($inst_last_id) ? $inst_last_id[0]->ckeck : '';

            # user input params of the tbl_general_educations table
            $general = $this->general_edu_param($request, $request->fam_id, $inst_lid, $hfid, 'update');
            # calling stored procedure for inserting and updating tbl_general_educations
            $genaral_add = DB::select('CALL general_education_info(?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $general);

            Session::flash('success','Updated Successfully..!');

            return redirect()->route('showFamiliesProfiles',[encrypt($request->hfid),encrypt($request->type),encrypt($request->prType),encrypt($request->page),encrypt($request->status),encrypt($request->personCat)]);

        } catch (\Exception $e) { return $e->getMessage(); }
    }

    protected function future_param($request,$person_id,$hfid,$operation)
    {
        try {
            return array($person_id, ucfirst($request->occupation_name), ucfirst($request->hobbies), ucfirst($request->goal), $request->type, $hfid, $operation);
            
        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function history_param($request,$ration_image,$fam_id,$hfid,$action)
    {
        try {
            return array($fam_id, $this->preg_replaces_field($request->present_door), $request->ration_no, $ration_image, $request->familial, $request->income, $request->income_source, ucfirst($request->HealthStatus), $request->shelter, $request->SelfReliant, $request->type, $hfid,$action,ucfirst($request->reason));
            
        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function inst_param($request)
    {
        try {
            return array($request->institution_id,ucfirst($request->institution_name),ucfirst($request->location),$request->sector,$request->institution_type,$request->community_type,$request->inst_street,$request->inst_city,$request->inst_district,$request->inst_state,$request->inst_pincode);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    protected function general_edu_param($request, $fam_id, $cid, $hfid, $img, $action)
    {
        try {
            return array($fam_id,$cid,ucfirst($request->course_name),$request->standard_grade,$request->qualification,$request->stage,$request->strength,ucfirst($request->weakness),$request->education_status,$request->performance,$img,$request->year,decrypt($request->type),$hfid,$action);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function iterateServiceConcern($person_id, $hfid,$category, $service, $concerns, $servProject, $conProject)
    {
        try {
            $i = 0;$j = 0;
            foreach($servProject as $sp){
                $up = ifAnd($service[$i]) ? $this->insertServiceConcern($person_id,$hfid,$category,$sp,$service[$i],'service') : '';
                $i++;
            }

            foreach($conProject as $cp){
                $up = ifAnd($concerns[$j]) ? $this->insertServiceConcern($person_id,$hfid,$category,$cp,$concerns[$j],'concern') : '';
                $j++;
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function loopServiceConcern($service, $concerns, $beneficiary)
    {
        try {
            $i = 0;$j = 0;
            foreach($beneficiary as $sc){
                $arr = (array) $sc;
                if($sc->service_type == 'service')
                    $up =  $this->updateServiceConcern($arr,$service[$i++]);
                else
                    $up =  $this->updateServiceConcern($arr,$concerns[$j++]);
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertServiceConcern($person_id, $hfid,$category,$servProj, $desc, $type)
    {
        try {
                return DB::table('tbl_service_conserns')
                    ->insert([ 'person_id' => $person_id , 
                        'description' => ucfirst($desc),
                        'project_type' => strtolower($servProj), 
                        'service_type' => strtolower($type),
                        'fam_category' => $category,
                        'hfid_link' => $hfid, 
                        'created_at' => Carbon::now('Asia/Kolkata') ]);
                    
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateServiceConcern($sc, $desc)
    {
        try {
                return DB::table('tbl_service_conserns')
                    ->where([ 'person_id' => $sc['person_id'] , 'hfid_link' => $sc['hfid_link'], 'project_type' => $sc['project_type'], 'service_type' => $sc['service_type'] ])
                    ->update(['description' => ucfirst($desc),
                        'updated_at' => Carbon::now('Asia/Kolkata') ]);
                    
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateFamiliesPersonal($request,$image,$adhar_image,$hfid)
    {
        try {
            return DB::table('tbl_families_personals')
                  ->where('id','=',$request->fam_id)
                  ->where('hfid', '=', $hfid)
                  ->update(['hfid'=> $hfid,
                        'fname'=>ucfirst($request->fname),
                        'lname'=>ucfirst($request->lname),
                        'image' => $image,
                        'dob'=>$request->dob,
                        'gender'=>$request->gender,
                        'birth_place'=>ucfirst($request->birth_palce),
                        'nationality'=>$request->nationality,
                        'relegion'=>$request->relegion,
                        'mother_tongue'=>$request->mother_tongue,
                        'marital_status'=>$request->marital_status,
                        'adhar_no'=>$request->adhar_no,
                        'adhar_image'=>$adhar_image,
                        'email'=>strtolower($request->email),
                        'phone'=>$request->phone,
                        'mobile'=>$request->mobile,
                        'blood_group'=>$request->blood_group,
                        'living'=>$request->living,
                        'relation'=>$request->relation,
                        'role' => $request->role,
                        'doj' => $request->doj,
                        'updated_at' => Carbon::now('Asia/Kolkata') ]);
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateAddresses($request,$addType,$person_id,$hfid)
    {
        try {
            return DB::table('tbl_families_address')
                  ->where('person_id','=',$person_id)
                  ->where('hfid_link', '=', $hfid) 
                  ->update(['door_no' => $this->preg_replaces_field(ucfirst($request->door_no)),
                        'street_area' => ucfirst($request->street),
                        'belongs_to' => ucfirst($request->belongs_to),
                        'city' => $request->city,
                        'district' => $request->district,
                        'state' => $request->state,
                        'pincode' => $request->pincode,
                        'add_type' => $addType,
                        'updated_at' => Carbon::now('Asia/Kolkata') ]);
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertAddresses($request,$addType,$person_id,$hfid)
    {
        try {
            return DB::table('tbl_families_address')
                  ->insert(['hfid_link' => $hfid,
                        'person_id' => $person_id,
                        'door_no' => $this->preg_replaces_field($request->door_no),
                        'street_area' => ucfirst($request->street),
                        'belongs_to' => ucfirst($request->belongs_to),
                        'city' => ucfirst($request->city),
                        'district' => ucfirst($request->district),
                        'state' => ucfirst($request->state),
                        'pincode' => ucfirst($request->pincode),
                        'add_type' => ucfirst($addType),
                        'fam_category' => $request->type,
                        'created_at' => Carbon::now('Asia/Kolkata') ]);
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $del = DB::table('families_models')
                        ->where('hfId','=',$request->val)
                        ->where('category','=',$request->type)
                        ->update(['status' => 0]);
            
            return $this->MSG('Deleted successfully!','Record deleted successfully...!','success');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function timeline($id,$hfid,$type,$prType,$page,$status,$personCat,$serveType)
    {
        try {
            // session(['id' => $id]);            
            $serve = $this->sPocAllServiceConcern($hfid,$type,$serveType);
            // dd($benefit);
            return view('admin.Projects.FamiliesInfo.FamiliesDataLink.timeline')->with('serve',$serve)->with('hfid',decrypt($hfid))->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($personCat))->with('serveType',decrypt($serveType));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
        // public function familiesProfileDetails($hfid,$type,$status)
    // {
    //     try {
    //         $post = DB::table('families_models')
    //                     ->select('families_models.*')
    //                     ->where('hfId','=',decrypt($hfid))
    //                     ->where('status','=',decrypt($status))
    //                     ->where('category','=',decrypt($type))
    //                     ->get();
    //         return $post;

    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

}
