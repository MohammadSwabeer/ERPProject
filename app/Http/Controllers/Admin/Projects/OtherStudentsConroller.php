<?php

namespace App\Http\Controllers\Admin\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Crypt;
use Carbon\Carbon;

class OtherStudentsConroller extends Controller
{

    public function index($type)
    {
        try {
            return view('admin.Projects.StudentsInfo.OtherStudents.addOtherStudents')->with('type',Crypt::decrypt($type));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            dd($request->all());
            $hfId = $request->hfname.$request->hfId;

            $mob = $this->mobile_exists('phone','mobile',$request->contact,$request->contact2);
            if($this->validate_data_mob($mob->getData()->value,'families_models',$mob->getData()->fields) <= 0){
                #find then roles i.e head/member
                $role = $this->predictHead($request->only('full_name','father_name','mother_name','husband_name','guardian_name'));
                # get father data from the form
                $father = $this->parentsColumns($request->except('_token','submit'),$hfId,$role->getData()->father,'Father','father_name','Male','father_occupation');

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
            $student = $this->studentColumns($request->except('_token','submit'),$hfId,$sRole,$img);

        	($insert) ? Session::flash('success','Inserted Successfully!') : Session::flash('error',' Not inserted!');
        	return redirect()->route('addOtherStudentsPage');
        } catch (Exception $e) {
        	return $e->getMessage();
        }
    }
}
