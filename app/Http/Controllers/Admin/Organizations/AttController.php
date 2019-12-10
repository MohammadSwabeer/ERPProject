<?php
namespace App\Http\Controllers\Admin\Organizations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\MainTraits;
use App\Http\Traits\UplaodImage;
use App\Http\Traits\DBFieldValidator;
use Carbon\Carbon;
use DB;
use Crypt;
use Session;

class AttController extends Controller
{
    use MainTraits, UplaodImage, DBFieldValidator;
    
    public function index($type,$prType,$page,$status,$person){ 
        try {
            return view('admin.Organizations.ATT.Students.addStudentDetails')->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function attStaffViewPage($type,$unit){
    	try {
    		$post = DB::table('organisation_details')
                    ->select('organisation_details.*')
                    ->where('organisation_details.m_status','=',1)
                    ->get();
    		return view('admin.Organizations.ATT.Staffs.index')->with('post',$post);
    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

    

    public function editATTStaffDetails($id){
    	try {
    		$post = $this->ATTStaffProfile($id);
    		return view('admin.Organizations.ATT.Staffs.editATTStaff')->with('post',$post);
    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

    public function updateATTStaffDetails(Request $request){
    	try {
            
    		$update = DB::table('organisation_details')->where('id','=',$request->id)->update([
		                'member_fname'=> $request->member_fname,
		                'member_mname'=> $request->member_mname,
		                'member_lname'=> $request->member_lname,
		                'email'=>$request->email,
		                'dob'=>$request->dob,
		                'doj'=>$request->doj,
		                'gender'=>$request->gender,
		                'qualification'=>$request->qualification,
		                'skills'=>$request->skills,
		                'permanent_address'=>$request->p_address,
		                'contact'=>$request->phone,
		                'p_residence'=>$request->p_residence,
		                'residence_address'=>$request->r_address,
		                'mobile'=>$request->mobile,
		                'r_residence'=>$request->rresidence,
		                'employment'=>$request->employment,
		                'company_name'=>$request->company_name,
		                'position'=>$request->position,
		                'working_since'=>$request->since,
		                'expertise'=>$request->expertise,
                        'other_organisation' =>$request->other_organisation,
                        'member_since' => $request->member_since,
                        'position_held' => $request->position_held,
		                'updated_at' => Carbon::now('Asia/Kolkata')
		            ]);
    		Session::flash('success','Updated Successfully!');
    		return redirect()->route('ATTStaffsView');
    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

    public function viewATTStaffProfile($id){
    	try {
    		$post = $this->ATTStaffProfile($id);

    		return view('admin.Organizations.ATT.Staffs.attStaffProfile')->with('post',$post);
    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

    public function ATTStaffProfile($id){
    	try {
    		$post = DB::table('organisation_details')
                    ->select('organisation_details.*')
                    ->where('organisation_details.m_status','=',1)
                    ->where('organisation_details.id','=',$id)
                    ->get();
    		return $post;
    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

    public function viewATTStudents(){
        try {
            $post = DB::table('att_students')
                    ->select('*')
                    ->where('status','=',1)
                    ->get();
            // dd($post);
            return view('admin.Organizations.ATT.Students.index')->with('post',$post);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    

    public function storeATTStudents(Request $request){
    	try {
            # validating mobile and email of the student
            $this->validator_mob_mail($request->all(),'families_models');
            # hfid for family
            $hfId = $request->hfname.$request->hfId;

            # checking parent's mobile number
            $mob = $this->mobile_exists('phone','mobile',$request->contact,$request->contact2);
            $gurMob = $this->mobile_exists('phone','mobile',$request->g_phone,$request->g_cell);
// validator_unique_field()
            $hus = (ifAnd($request->husband_name) == true) ? 'husband_name' : null;
            $gur = (ifAnd($request->guardian_name) == true) ? 'guardian_name' : null;
            dd($this->validate_data_mob($mob->getData()->value,'families_models',$mob->getData()->fields));
            if(ifEqual($this->validate_data_mob($mob->getData()->value,'families_models',$mob->getData()->fields)) == true ){
                #find the roles i.e head/member
                $role = $this->predictHead($request->only('full_name','father_name','mother_name',$hus,$gur));

                # get father data from the form
                $father = $this->parentsColumns($request->except('_token','submit'),$hfId,$role->getData()->father,'Father','father_name','Male',$mob->getData()->value,'father_occupation');

                # custom values for role
                $motherRole = $role->getData()->mother;
                $husRole = $role->getData()->hus;
                $gRole = $role->getData()->gurd;
                $sRole = $role->getData()->stud;

            } else {
                # find the hfid to apply member's info to existing family
                $father = null;
                $hfId =$this->showDBData('families_models','hfId',$mob->getData()->value,$mob->getData()->fields)[0]->hfId;
                $motherRole = $husRole = $gRole = $sRole = 'Member';
            }
            dd($hfId);
            // dd('hxbxhchxch');
            # custom values and image uploading
            $conc = $request->full_name.$hfId;
            $img = $this->saveImage($request->stud_image,$this->getImagePath($request->hfname),$conc);

            # get student data from the from
            $student = $this->studentColumns($request->except('_token','submit'),$hfId,$sRole,$img);
            
            # get mother data from the form
            $mother = $this->parentsColumns($request->except('_token','submit'),$hfId, $motherRole,'Mother','mother_name','Female',($motherRole != 'Member') ? $mob->getData()->value : null,'mother_occupation');
            # checking mother for same family member adding purpose
            $mother = ( ifAnd($mother) == true && ifEqual($this->find_data('families_models','full_name','hfId',$hfId,$request->mother_name) == true) ) ? $mother : null;

            # get husband data from the form
            $husband = $this->parentsColumns($request->except('_token','submit'),$hfId,$husRole,'Husband',$hus,'Male',null,'husband_occupation');

            # get gurdian data from the form
            $gurdian = $this->parentsColumns($request->except('_token','submit'),$hfId,$gRole,'Guardian',$gur,'Male',$gurMob->getData()->value);
            # checking gurdian for same family member adding purpose
            $gurdian = (ifAnd($gurdian) == true && ifEqual($this->find_data('families_models','full_name','hfId',$hfId,$request->guardian_name) == true) ) ? $gurdian : null;

            # inserting data into table
            $data = array( $father, $mother, $husband, $gurdian, $student );
            foreach($data as $values){
                $insert = $this->insertData($values,'families_models');
            }

            # to get student last inserted data from table  for eval table
            $stdid = $this->getStudentData([$request['category']]);

            # student general education details(first assessment)
            $eval = $this->evalColumns($request->except('_token','submit'), $stdid[0]->id);
            $this->insertData($eval,'studentevaluations');
            
            ($insert) ? Session::flash('success','Inserted Successfully!') : Session::flash('error',' Not inserted!');

            return redirect()->route(($request->hfname == 'HFATT') ? 'ATTStudentsAddPage' : 'addOtherStudentsPage',[Crypt::encrypt($request['category'])]);

    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

    public function getStudentData($type){
        try {
                $post = DB::table('families_models')
                            ->select('id')
                            ->where('status','=',1)
                            ->where('occupation','=','Student')
                            ->where('category','=',$type)
                            ->orderBy('id','DESC')
                            ->limit(1)
                            ->get();

                return $post;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function studentColumns(array $request, $hfid, $role,$img){
        try {
              return ['hfId' => $hfid, 
                    'full_name' => ucfirst($request['full_name']), 
                    'category' => $request['category'],
                    'image' => ($img != '') ? $img : null, 
                    'dob' => $request['dob'], 
                    'birth_place' => (key_find($request,'birth_place') != null) ? $request['birth_place'] : null, 
                    'gender' => $request['gender'], 
                    'email' => strtolower($request['email']), 
                    'mobile' => $request['mobile'], 
                    'phone' => (key_find($request,'phone') != null) ? $request['phone'] : null, 
                    'relation' => ($request['gender'] != 'Male') ? 'Daughter' : 'Son', 
                    'role' => $role,
                    'marital_status' => (key_find($request,'stud_marital') != null) ? $request['stud_marital'] : null, 
                    'nationality' => (key_find($request,'nationality') != null) ? $request['nationality'] : null, 
                    'relegion' => (key_find($request,'relegion') != null) ? $request['relegion'] : null, 
                    'mother_tongue' => (key_find($request,'mother_tongue') != null) ? $request['mother_tongue'] : null, 
                    'occupation' => 'Student', 
                    'qualification' => $request['qualification'], 
                    'present_street' => ucfirst($request['full_address']), 
                    'present_city' => (key_find($request,'presentCity') != null) ? $request['presentCity'] : null, 
                    'district' => (key_find($request,'district') != null) ? $request['district'] : null,
                    'present_state' => (key_find($request,'presentState') != null) ? $request['presentState'] : null, 
                    'present_pincode' => $request['pincode'], 
                    'user_name' => strtolower($request['email']), 
                    'password' => $request['dob'] 
                ];

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function parentsColumns(array $request, $hfid, $role, $relation, $name, $gender, $mob = '', $occupation =''){
        try {
            if( condition($request,$name) == true ){
                return ['hfId'=> $hfid, 
                    'full_name' => ucfirst($request[$name]), 
                    'category' => $request['category'],
                    'relation'=> $relation, 
                    'role'=> $role, 
                    'gender'=> $gender,
                    'mobile'=> (ifAnd($mob) == true) ? $mob->mobile : null, 
                    'phone'=> (ifAnd($mob) == true) ? $mob->email : null, //means phone
                    'marital_status'=> 'Married', 
                    'nationality' => (key_find($request,'nationality') != null) ? $request['nationality'] : null, 
                    'relegion'=> (key_find($request,'relegion') != null) ? $request['relegion'] : null, 
                    'mother_tongue' => (key_find($request,'mother_tongue') != null) ? $request['mother_tongue'] : null, 
                    'occupation'=> ($relation != 'Guardian') ? $request[$occupation] : null, 
                    'income'=> ($role == 'Head') ? $request['annual'] : null,
                    'category'=> $request['category'],
                    'present_street' => ($relation != 'Guardian') ? $request['full_address'] : $request['g_address'], 
                    'present_pincode' => ($relation != 'Guardian') ? $request['pincode'] : $request['g_pincode'], 
                    'user_name' => $request[$name], 
                    'password' => $hfid 
                ];
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function evalColumns(array $request, $studid){
        try {
            if( condition($request,'qualification') == true || condition($request,'course') == true && condition($request,'performance') == true ){
                return [ 'stdid' => $studid,
                    'category' => $request['category'],
                    'grade'=> $request['qualification'],
                    'school_college_name'=> $request['school_college_name'],
                    'course'=> $request['course'],
                    'rank_name'=>(key_find($request,'rank_name') != null) ? (ifAnd($request['rank_name']) == true) ? implode($request['rank_name']) : null : null,
                    'rank_list'=> (key_find($request,'rank_name') != null) ?  (ifAnd($request['rank_list']) == true) ? implode($request['rank_list']) : null : null,
                    'performance'=> $request['performance'],
                    'year'=> $this->current_date_format(),
                    'remark'=> $request['performance']
                ];
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }



    public function editATTStudents($id){
        try {
                $post = $this->attStudentData($id);
                return view('admin.Organizations.ATT.Students.editATTStudent')->with('post',$post);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function attStudentData($id){
        try {
                return DB::table('att_students')->select('*')
                        ->where('id','=',$id)
                        ->where('status','=',1)
                        ->get();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ATTStudentsProfile($id){
        try {
                $post = $this->attStudentProfile($id);
                $years = $this->showYear($id);
                // dd($post);
                return view('admin.Organizations.ATT.Students.ATTStudentProfile')->with('post',$post)->with('years',$years);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function attStudentProfile($id){
        try {
            return DB::table('att_students')
                    ->leftJoin('studentevaluations', 'studentevaluations.stdid', '=', 'att_students.id')
                    ->select('att_students.*',
                            'studentevaluations.id as eval_id',
                            'studentevaluations.stdid',
                            'studentevaluations.stage',
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
                    ->where(['att_students.id' =>$id,'att_students.status' => 1])
                    ->orWhere('studentevaluations.category','=','ATTSTUD')
                    ->orderBy('studentevaluations.year','DESC')
                    ->get();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function updateATTStudents(Request $request){
        try {
                $update = DB::table('att_students')->where('id','=',$request->id)->update([
                           'hfId' => $request->hfId,
                           'full_name' => $request->full_name,
                           'gender' => $request->gender,
                           'stud_email' => $request->stud_email,
                           'stud_phone' => $request->stud_phone,
                           'stud_cell' => $request->stud_cell,
                           'stud_dob' => $request->stud_dob,
                           'birth_place' => $request->birth_place,
                           'stud_marital' => $request->stud_marital,
                           'nationality' => $request->nationality,
                           'relegion' => $request->relegion,
                           'mother_tongue' => $request->mother_tongue,
                           'qualification' => $request->qualification,
                           'college_last_attended' => $request->college_last_attended,
                           'father_name' => $request->father_name,
                           'father_occupation' => $request->father_occupation,
                           'mother_name' => $request->mother_name,
                           'mother_occupation' => $request->mother_occupation,
                           'husband_name' => $request->husband_name,
                           'husband_occupation' => $request->husband_occupation,
                           'annual' =>$request->annual,
                           'guardian_name' => $request->guardian_name,
                           'g_phone' => $request->g_phone,
                           'g_cell' => $request->g_cell,
                           'full_address' => $request->full_address,
                           'pincode' => $request->pincode,
                           'g_address' => $request->g_address,
                           'g_pincode' => $request->g_pincode
                        ]);

            Session::flash('success','Updated Successfully!');
            return redirect()->route('viewATTStudents');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //   try 
    //   {
    //     $check = DB::table('organisation_details')
    //         ->where('dob','=',$request->dob)
    //         ->where('email','=',$request->email)
    //         ->where('contact','=',$request->phone)
    //         ->orWhere('mobile','=',$request->mobile)
    //         ->count();
    //     if ($check > 0) {
    //         Session::flash('error','Record already exists...');
    //         return redirect()->route('organisationDetails.create');
    //     }
        

    //     $name = null;
    //     $other_organisation = null;
    //     $position_held = null;
    //     $member_since = null;
    //     if ($request->other_organisation != null || $request->position_held !=null || $request->member_since!= null) {
    //       $other_organisation = implode(',',$request->other_organisation);
    //       $position_held = implode(',',$request->position_held);
    //       $member_since = implode(',',$request->member_since);
    //     }
        

    //         $inputdob= strtotime($request->dob);//user input converting to string
    //         date_default_timezone_set('Asia/Calcutta');//indian timezone
    //         $date = date('Y-m-d H:i:s', time());//current date-time 
    //         $currentdate= strtotime($date);//converting current date time to string
    //         $currentage= date('Y',$currentdate) - date('Y', $inputdob);//sub of user date and current date to find age

    //         if ($currentdate < $inputdob || $currentdate < $request->doj) {
    //             Session::flash('error','date of birth/date of join is should be lesser than current date...');
    //             return view('admin.unit.members.organization');
    //         }
    //         // uploading photo to folder
    //         if ($request->image != null) {
    //             $image=$request->image;
    //             $name=$request->image->getClientOriginalName();
    //             $dest=public_path('adminAssets/images/profileUploads');
    //             $image->move($dest,$name);
    //         }
    //         DB::table('organisation_details')->insert([
    //            'photo' => $name,
    //            'member_fname' => $request->member_fname,
    //            'member_mname' => $request->member_mname,
    //            'member_lname' => $request->member_lname,
    //            'unit' => $request->unit,
    //            'role' => $request->role,
    //            'email' => $request->email,
    //            'dob' => $request->dob,
    //            'doj' => $request->doj,
    //            'gender' => $request->gender,
    //            'member_age' => $currentage,
    //            'permanent_address' => $request->p_address,
    //            'contact' => $request->phone,
    //            'p_residence' => $request->p_residence,
    //            'residence_address' => $request->r_address,
    //            'mobile' => $request->mobile,
    //            'r_residence' => $request->rresidence,
    //            'qualification' => $request->qualification,
    //            'employment' => $request->employment,
    //            'company_name' => $request->company_name,
    //            'position' => $request->position,
    //            'working_since' => $request->since,
    //            'expertise' => $request->expertise,
    //            'skills' => $request->skills,
    //            'other_organisation' =>$other_organisation,
    //            'member_since' => $member_since,
    //            'position_held' => $position_held
    //        ]);

    //         Session::flash('success','Record inserted successfully...');
    //         return redirect()->route('organisationDetails.create');

    //     } catch (\Exception $e) {
    //        return $e->getMessage();
    //   }
    // }
}
