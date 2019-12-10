<?php

namespace App\Http\Controllers\Admin\Organizations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\MainTraits;
use App\Http\Traits\DBFieldValidator;
use App\Http\Traits\UplaodImage;
use DB;
// use App\organisation_details;
use App\AdminModels\UnitModel;
use Session;
use Hash;
// use Crypt;
use Carbon\Carbon;

class OrganizationController extends Controller
{
  use MainTraits, DBFieldValidator, UplaodImage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try {
          $units = UnitModel::all();
          return view('admin.Organizations.startPage')->with('units',$units);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type,$prType,$page,$status,$person,$unit)
    {
      try {
          return view('admin.Organizations.LinkedMemberData.basicInfo.addMemberInfo')->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person))->with('unit',decrypt($unit));

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    public function storeOrganizationDetails(Request $request)
    {
        try {
            # validating mobile and mail for uniq
            $valid = $this->mobile_exists('email', 'mobile', $request->email, $request->mobile);
            if($this->validate_data_mob($valid->getData()->value,'users',$valid->getData()->fields) > 0){
                Session::flash('error','Mobile Number / Email already exists');
               return redirect()->back()->withInput();
             }
          
            # validating date of birth less than join date
            $currentdate = $this->current_date();
            if ($currentdate < $request->dob || $currentdate < $request->doj || $request->doj < $request->dob){
                Session::flash('error','date of birth/ date of join is should be lesser than current date.');
                return redirect()->back()->withInput();
              }

            # validate all data
            $fields = ['email' => 'email','name' => 'member_fname' ,'mobile' => 'mobile','dob' => 'dob'];
            $request_data = ['name' => $request->member_fname,'email' => $request->email,'mobile' => $request->mobile,'dob' => $request->dob];
            if($this->validate_data((object)$request_data,'users',(object) $fields) > 0){
              Session::flash('error','Record already exists...');
              return redirect()->back()->withInput();
            }

            #hf id concat
            $hfId = $this->getHFID($request->type,$request->member_type).$request->hfId;
            // dd($hfId);
            
            # Uploading photo to folder
            $names = $request->member_fname.$request->member_mname.$request->member_lname;
            $conc = $names.$hfId;
            $name = $this->saveImage($request->image,$this->getImagePath('ATTStaff'),$conc);

            # inserting data to model
            $insert = DB::table('users')->insert([
                     'hfId' => $hfId,
                     'photo' => $name,
                     'category' => $request->type,
                     'committee' => $request->committee,
                     'role' => $request->role,
                     'member_type' => $request->member_type,
                     'member_fname' => ucfirst($request->member_fname),
                     'member_mname' => ucfirst($request->member_mname),
                     'member_lname' => ucfirst($request->member_lname),
                     'unit_id' => $request->unit,
                     'email' => strtolower($request->email),
                     'password' => Hash::make($request->dob),
                     'dob' => $request->dob,
                     'doj' => $request->doj,
                     'gender' => $request->gender,
                     'permanent_address' => $request->p_address,
                     'mobile' => $request->mobile,
                     'p_city' => $request->p_city,
                     'p_state' => $request->p_state,
                     'p_nation' => $request->p_nation,
                     'p_residence' => $request->p_residence,
                     'residence_address' => $request->r_address,
                     'contact' => $request->phone,
                     'r_city' => $request->r_city,
                     'r_state' => $request->r_state,
                     'r_nation' => $request->r_nation,
                     'r_residence' => $request->rresidence,
                     'qualification' => ucfirst($request->qualification),
                     'designation' => ucfirst($request->employment),
                     'company_name' => $request->company_name,
                     'position' => ucfirst($request->position),
                     'working_since' => $request->since,
                     'expertise' => ucfirst($request->expertise),
                     'skills' => ucfirst($request->skills),
                     'other_organisation' => (ifAnd($request->other_organisation) == true) ? implode(',',$request->other_organisation) : null,
                     'member_since' => (ifAnd($request->other_organisation) == true) ? implode(',',$request->member_since) : null,
                     'position_held' => (ifAnd($request->other_organisation) == true) ? implode(',',$request->position_held) : null,
                     'created_at' => Carbon::now('Asia/Kolkata')
                  ]);

            ($insert) ? Session::flash('success','Inserted Successfully!') : Session::flash('error',' Not inserted!');

            return redirect()->route('addMemberInfo',[encrypt($request->type),encrypt($request->unit),encrypt($request->page)]);

        } catch (\Exception $e) {
           return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllMembers($type,$unit)
    {
      try {
            return DB::table('users')
                    ->leftJoin('unit_details','unit_details.id','=','users.unit_id')
                    ->select('users.*',
                          'unit_details.id as uid',
                          'unit_details.unit_name')
                    ->where('category','=', decrypt($type))
                    ->where('unit_id','=', decrypt($unit))
                    ->get();

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAllMembers($type,$prType,$page,$status,$person,$unit)
    {
      try {
        // dd(decrypt($person));
              $post = $this->getAllMembers($type,$unit);
              // dd($post);
            return view('admin.Organizations.LinkedMemberData.basicInfo.index')
                  ->with('post',$post)->with('type',decrypt($type))->with('prType',decrypt($prType))->with('page',decrypt($page))->with('status',decrypt($status))->with('personCat',decrypt($person))->with('unit',decrypt($unit));

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function performanceIndicator($id,$type,$unit,$page)
    {
      try {
            $post = $this->getProfile($id,$type,$unit);

            return view('admin.Organizations.LinkedMemberData.Assessments.performanceIndicators')
                  ->with('post',$post)
                  ->with('id',decrypt($id))
                  ->with('page',decrypt($page))
                  ->with('type',decrypt($type))
                  ->with('unit',decrypt($unit));

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function memberPhysicalCredit($id,$type,$unit,$page,$credit)
    {
      try {
            $post = $this->getProfile($id,$type,$unit);

            return view('admin.Organizations.LinkedMemberData.Assessments.memberPhysicalCredits')
                  ->with('post',$post)
                  ->with('id',decrypt($id))
                  ->with('page',decrypt($page))
                  ->with('type',decrypt($type))
                  ->with('credit',decrypt($credit))
                  ->with('unit',decrypt($unit));

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function memberReport($id,$type,$unit,$page)
    {
      try {
            $post = $this->getProfile($id,$type,$unit);

            return view('admin.Organizations.LinkedMemberData.Assessments.memberReport')
                  ->with('post',$post)
                  ->with('id',decrypt($id))
                  ->with('page',decrypt($page))
                  ->with('type',decrypt($type))
                  ->with('unit',decrypt($unit));

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function yearlyPlanner($id,$type,$unit,$page)
    {
      try {
            $post = $this->getProfile($id,$type,$unit);

            return view('admin.Organizations.LinkedMemberData.Assessments.yearlyPlanner')
                  ->with('post',$post)
                  ->with('id',decrypt($id))
                  ->with('page',decrypt($page))
                  ->with('type',decrypt($type))
                  ->with('unit',decrypt($unit));

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function staffAssessments($id,$type,$unit,$page)
    {
      try {
            $post = $this->getProfile($id,$type,$unit);

            return view('admin.Organizations.LinkedMemberData.Assessments.StaffAssessments.getStaffAssessments')
                  ->with('post',$post)
                  ->with('id',decrypt($id))
                  ->with('page',decrypt($page))
                  ->with('type',decrypt($type))
                  ->with('unit',decrypt($unit));

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printReport($id,$type,$unit,$page)
    {
      try {
            $post = $this->getProfile($id,$type,$unit);

            return view('admin.Organizations.LinkedMemberData.Assessments.printReport')
                  ->with('post',$post)
                  ->with('id',decrypt($id))
                  ->with('page',decrypt($page))
                  ->with('type',decrypt($type))
                  ->with('unit',decrypt($unit));

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    

    public function getMemberProfile($id,$type,$unit,$page){
      try {
        // dd($id);
        $post = $this->getProfile($id,$type,$unit);
        // dd($post);
        return view('admin.Organizations.LinkedMemberData.basicInfo.getMemberProfile')
                  ->with('post',$post)
                  ->with('type',decrypt($type))
                  ->with('page',decrypt($page))
                  ->with('unit',decrypt($unit));

      } catch (Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProfile($id,$type,$unit){
      try {
        // dd(decrypt($unit));
        $post = DB::table('users')
                    ->leftJoin('unit_details','unit_details.id','=','users.unit_id')
                    ->select('users.*',
                          'unit_details.id as uid',
                          'unit_details.unit_name')
                    ->where('users.category','=', decrypt($type))
                    ->where('users.unit_id','=', decrypt($unit))
                    ->where('users.id','=',decrypt($id))
                    ->where('users.status','=',1)
                    ->get();
                    // dd($post);
        return $post;
      } catch (Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $inputdob = date('Y-m-d', strtotime($request->dob));
            $date = Carbon::now();
            $currentdate = $date->toDateString();
            $currentage = Carbon::parse($request->dob)->age;

            DB::table('users')->where('id','=',$id)->update(['member_fname'=> $request->member_fname,
                'member_mname'=> $request->member_mname,
                'member_lname'=> $request->member_lname,
                'unit'=>$request->unit_name,
                'email'=>$request->email,
                'dob'=>$request->dob,
                'doj'=>$request->doj,
                'gender'=>$request->gender,
                'qualification'=>$request->qualification,
                'skills'=>$request->skills,
                'permanent_address'=>$request->permanent_address,
                'contact'=>$request->contact,
                'p_residence'=>$request->p_residence,
                'residence_address'=>$request->residence_address,
                'mobile'=>$request->mobile,
                'r_residence'=>$request->r_residence,
                'employment'=>$request->employment,
                'company_name'=>$request->company_name,
                'position'=>$request->position,
                'working_since'=>$request->working_since,
                'member_age'=>$currentage,
                'gender'=>$request->gender,
                'expertise'=>$request->expertise
            ]);

            Session::flash('success','Record updated successfully...');
            return redirect()->route('organisationDetails.index');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        Users::find($id)->delete();
        Session::flash('error','Record deleted successfully...');
        return redirect()->route('organisationDetails.index');
      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    static function org_explode($args,$string)
    {
      switch ($string){ 
        case 'other_org':
              $explode = explode(',',$args);
              foreach ($explode as $explodes) {
                $a[] = $explodes;
              }
          break;
        
        case 'since':
              $explode = explode(',',$args);
              foreach ($explode as $explodes) {
                $a[] = $explodes;
              }
          break;

          case 'position':
              $explode = explode(',',$args);
              foreach ($explode as $explodes) {
                $a[] = $explodes;
              }
          break;
      }
          return $a;
    }    
  }
