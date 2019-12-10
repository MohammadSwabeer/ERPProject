<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Carbon\Carbon;

trait MainTraits
{
    protected function validator_mob_mail(array $data, $model)
    {   
        // dd($data);
        return Validator::make($data, [
            'mobile' => (checkZero($data,'mobile') == true) ? ['max:10', 'unique:'.$model] : ['max:10'],
            'email' => (condition($data,'email') == true) ? ['required','string', 'email', 'max:255', 'unique:'.$model] :['required'],
        ])->validate();
    }

    protected function validate_start_end_date(array $data)
    {
        return Validator::make($data, [
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
        ]);
    }

    protected function validate_uniques(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required','string', 'unique:tbl_families_personals'],
            'lname' => ['string','unique:tbl_families_personals'],
            'dob' => ['date','unique:tbl_families_personals']
        ]);
    }

    protected function validator_unique_field(array $data, $model,$field,$requested_field)
    {
        return Validator::make($data, [
            $field => ($data[$requested_field] != null && $data[$requested_field] != '')?['max:10', 'unique:'.$model] : ['required'],
        ]);
    }

    public function validate_mobile($request_data,$model,$fields){
        try {
            // dd($request_data->phone);
            $check = DB::table($model)
                ->select($fields->phone,$fields->mobile)
                ->where($fields->phone,'=',$request_data->phone)
                ->orWhere($fields->mobile,'=',$request_data->mobile)
                ->count();
                // dd($check);
                return $check;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function preg_replaces_field($request_data){
		return preg_replace('/\s+/', '',ucfirst($request_data));
    }

    public function redirect_route($type,$msg,$path){
        try {
            Session::flash($type,$msg);
            return redirect()->route($path);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function redirect_route_with_param($msg_type,$msg,$path,$hfid){
        try {
            
            Session::flash($msg_type,$msg);
            return redirect()->route($path,[$hfid]);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function redirect_route_param($msg_type,$msg,$path,$params){
    	try {
            Session::flash($msg_type,$msg);
            return redirect()->route($path,$params);

    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

    public function redirect_view($type,$msg,$path){
    	try {
    		Session::flash($type,$msg);
		    return view($path);
    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

	public function current_date(){
        try {
            date_default_timezone_set('Asia/Calcutta');//indian timezone
            return strtotime(date('Y-m-d H:i:s', time()));//converting current date time to string
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function current_date_format(){
    	try {
			date_default_timezone_set('Asia/Calcutta');//indian timezone
	        return date('Y-m-d', time());//converting current date time to string
    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

    public static function age($args) {
        return ($args !== null || $args !== '') ? Carbon::parse($args)->age : $args;
    }

    public function MSG($act,$message,$status) {
        try{
            $response['act']  = $act;
            $response['message'] = $message;
            $response['status']  = $status;
            return json_encode($response);

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function filterData($type) {
        try{
            if($type == 'HSCC')
                return $this->filterHSCC();

            if($type == 'MR')
                return $this->filterHSCC();

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function filterHSCC() {
        try{
            $filter['name'] = ['Door/House No','HFSCC-ID','Full Name','Age','Date of Join','Qualification','Occupation'];
            $filter['param'] = ['present_door','hfid','fname','dob','doj','qualification','occupation_name'];
            $filter['pos'] = [1,2,3,7,8,9,10];

            return json_encode($filter);

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function mobile_exists($c1 = '',$c2,$v1='',$v2) {
        try{
            $data['fields'] = [ 'email' => $c1, 'mobile' => $c2 ];
            $data['value'] = ['email' => $v1, 'mobile' => $v2 ];

            return response()->json($data);

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function preg_clear($data){
        $preg['data'] = preg_replace('/\d+/u', '', $data);
        preg_match_all('!\d+!', $data, $preg['pos']);
        return json_encode($preg);
    }

    public function predictHead(array $data){
        try {
                $hus = key_find($data,'husband_name');
                $gur = key_find($data,'guardian_name');
                $role['father'] = (condition($data,'father_name') == true) ? conditions($data,$hus) : null;
                $role['mother'] = (condition($data,'mother_name') == true ) ? conditions($data,'father_name') :null;
                $role['hus'] = (condition($data,$hus) == true ) ? 'Head' : null;
                $role['gurd'] = (condition($data,$gur) == true ) ? condition3($data,'father_name','mother_name',$hus) : null;
                $role['stud'] = (condition($data,'full_name') == true ) ? condition4($data,'father_name','mother_name',$hus,$gur) : null;

                return response()->json($role);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getHFID($type,$person = '')
    {
      try {
            switch ($type) {
                case 'ATT':
                    return ($person == 'Staff') ? 'HFATS' : 'HFATT';
                    break;

                case 'Youth Wing':
                    return 'HFYW';
                    break;

                case 'Womens Wing':
                    return "HFWW";
                    break;

                case 'Girls Wing':
                    return "HFGW";
                    break;

                case 'HSCC':
                    return ($person == 'Staff') ? "HFSCCS" : "HFSCC";
                    break;

                case 'MR':
                    return "HFMR";
                    break;

                case 'HQ Admin':
                    return "HFHQS";
                    break;

                case 'Ground':
                    return "HFGS";
                    break;

                case 'ATT':
                    return "HFATS";
                    break;
                
                default:
                    return null;
                    break;
            }
            // if($type == '')
            //   $hfid = ;

            // if($type == 'Youth Wing')
            //   $hfid = 'HFYW';

            // if($type == 'Womens Wing')
            //   $hfid = 'HFWW';

            // if($type == 'Girls Wing')
            //   $hfid = 'HFGWW';

            // if($type == 'HSCC')
            //   $hfid = 'HFSCCS';

            // if($type == 'HQ Admin')
            //   $hfid = 'HFHQA';

            // if($type == 'Ground')
            //   $hfid = 'HFGSA';

            // if($type == 'OverseasRiyadh')
            //   $hfid = 'HFOSR';

            // if($type == 'OverseasDammam')
            //   $hfid = 'HFOSD';

            // if($type == 'OverseasJubail')
            //   $hfid = 'HFOSJ';

            // if($type == 'OverseasJeddha')
            //   $hfid = 'HFOSJD';

            // if($type == 'OverseasDubai')
            //   $hfid = 'HFOSDU';

            // if($type == 'OverseasQatar')
            //   $hfid = 'HFOSQ';

            // if($type == 'OverseasMuscat')
            //   $hfid = 'HFOSM';

            // if($type == 'OverseasBahrain')
            //   $hfid = 'HFOSB';

            // if($type == 'OverseasBangalore')
            //   $hfid = 'HFOSBL';

            return $hfid;

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    public function getServiceConcerns($id,$hfid,$status)
    {
        try {
            $post = DB::table('tbl_service_conserns')
                        ->select('hfid_link','person_id','description','project_type','service_type')
                        ->where('hfid_link','=',$hfid)
                        ->where('status','=',$status)
                        ->where('person_id','=',$id)
                        ->get();
            return $post;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getInDate($y)
    {
        try {
            return ifAnd($y) ? $y : date('Y-m-d');

        } catch (\Exception $e) { return $e->getMessage(); }
    }
}
