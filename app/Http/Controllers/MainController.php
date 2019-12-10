<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\MainTraits;
use App\Http\Traits\UplaodImage;
use App\Http\Traits\DBFieldValidator;
use App\Http\Traits\Admin\BreadCrumbs;
use App\Http\Traits\Admin\PopModels;
use App\Http\Traits\Admin\StoredProcedures;
use DB;
use Carbon\Carbon;
use Crypt;

class MainController extends Controller
{
	use MainTraits, UplaodImage, DBFieldValidator, BreadCrumbs, PopModels,StoredProcedures;

    public $btn = [];public $route=[];public $id=[];

	static function findRelation($relation) {
		try {
			if($relation == 'Daughter')
				return 'Sister';
			else if($relation == 'Son')
				return 'Brother';
			else if($relation == 'Mother')
				return 'Mother';
			else
				return 'Father';
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

    public function COUNTS($tblName,$colname,$id) {
		return $count  = DB::table($tblName)->where($colname,'=',$id)->count();
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

    public static function remark($args) {
		if ($args >= 95 && $args <= 100){
			$args = 'Exllence';
		}
		else if($args >= 80 && $args <= 94){
			$args = 'Very good';
		}
		else if($args >= 60 && $args <= 79){
			$args = 'Good';
		}
		else if($args >= 40 && $args <= 59){
			$args = 'Average';
		}
		else{
			$args = 'Need to be improved';
		}

		return $args;		
	}

	public static function remarkRelegious($args) {
		if($args >= 70 && $args <= 100){
			$args = 'High';
		}
		else if($args >= 40 && $args <= 69){
			$args = 'Moderate';
		}
		else{
			$args = 'Low';
		}

		return $args;
	}

	public static function age($args) {
        return ($args !== null || $args !== '') ? Carbon::parse($args)->age : $args;
	}

	public static function dateFind($args) {
		return date('d/m/Y', strtotime($args));
	}

	public static function ONLY_YEAR($args) {
		return date('Y', strtotime($args));
	}

	public static function DATE_FORMAT_DASH($args) {
		return date('d-m-Y', strtotime($args));
	}

	public static function dateMonth($args) {
		return date('d M', strtotime($args));
	}

	public static function fullDate($args) {
		return date('d-D-M-Y', strtotime($args));
	}

	public static function SET_SESSION() {

		if(Session::has('user')){
			return redirect()->route('user.index');
		}else{
			return redirect()->route('welcome');
		}
	}

    

	static function EXPLODE_DATA($args)
    {
      	$explode = explode(',',$args);
        return $explode;
    }

    public function modelData($type) {
        try{
            switch ($type) {
            	case 'Parents':
            		return $this->params('Parents Info','ATT Parents Info','Workshop Parents Info','Other');
            		break;

            	case 'Teachers':
            		return $this->params('Teachers Info','ATT Staff Info','ATT Trained Teachers Info','Other Institution','viewMembers',null,null,encrypt('ATT'),null,null,encrypt(1),null,null,encrypt('Projects'));
            		break;

            	case 'School':
            		return $this->params('School Management','CBSE','State','Other');
            		break;

            	case 'Resource':
            		return $this->params('Resource Persons','Counsellors','Professionals','Career Guidance');
            		break;

            	case 'FPrevention':
            		return $this->params('Prevention','Food Wastage Campaign');
            		break;

            	case 'FCure':
            		return $this->params('Cure','HSCC Families','MR Families','Other Families','viewFamiliesPage','viewFamiliesPage',null,encrypt('HSCC'),encrypt('MR'));
            		break;

            	case 'HPrevention':
            		return $this->params('Prevention','Rural','Urban');
            		break;

            	case 'HCure':
            		return $this->params('Cure','Rural','Urban');
            		break;

            	case 'Data':
            		return $this->params('Data','Hospitals','Doctors');
            		break;

            	case 'Colony':
            		return $this->params('HSCC Colony','HSCC Families','HSCC Students',null,'viewFamiliesPage','viewStudentsInfo',null,encrypt('HSCC'),encrypt('HSCC'),null,null,encrypt('Projects'));
            		break;
            	
            	default:
            		return $this->params('','','','','','','','','','');
            		break;
            }

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function params($title,$btn,$btn2 = '',$btn3 = '',$route = '',$route2 = '',$route3 = '',$id = '',$id2 = '',$id3 = '',$id21='',$id22 ='',$id23 ='',$id31='',$id32 ='',$id33 ='') {
        try{
	            $mod['title'] = (ifAnd($title) == true) ? $title : '';
	            $mod['btn'] = (ifAnd($btn) == true) ? $btn : '';
	            $mod['btn2'] = (ifAnd($btn2) == true) ? $btn2 : '';
	            $mod['btn3'] = (ifAnd($btn3) == true) ? $btn3 : '';
	            $mod['route'] = (ifAnd($route) == true) ? $route : null;
	            $mod['route2'] = (ifAnd($route2) == true) ? $route2 : null;
	            $mod['route3'] = (ifAnd($route3) == true) ? $route3 : null;
	            $mod['id'] = (ifAnd($id) == true) ? $id : null;
	            $mod['id2'] = (ifAnd($id2) == true) ? $id2 : null;
	            $mod['id3'] = (ifAnd($id3) == true) ? $id3 : null;
	            $mod['id21'] = (ifAnd($id21) == true) ? $id21 : null;
	            $mod['id22'] = (ifAnd($id22) == true) ? $id22 : null;
	            $mod['id23'] = (ifAnd($id23) == true) ? $id23 : null;
	            $mod['id31'] = (ifAnd($id31) == true) ? $id31 : null;
	            $mod['id32'] = (ifAnd($id32) == true) ? $id32 : null;
	            $mod['id33'] = (ifAnd($id33) == true) ? $id33 : null;

            return response()->json($mod);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function popUpData($type) {
        try{

        	switch ($type) {
        		case 'Providers':
            		return $this->getParam('Providers or Employers','Indian','Oversease','Providers');
            		break;

            	case 'Seekers':
            		return $this->getParam('Job Seekers','In House','Outsourcing','Seekers');
            		break;
        		
        		default:
        			return null;
        			break;
        	}
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function getParam($title,$btn,$btn2, $type) {
        try{
	            $pop['title'] = (ifAnd($title) == true) ? $title : '';
	            $pop['btn'] = (ifAnd($btn) == true) ? $btn : '';
	            $pop['btn2'] = (ifAnd($btn2) == true) ? $btn2 : '';
	            $pop['param']=  (ifAnd($type) == true) ? $this->getBtn($type) : null;
	            $pop['param2']=  (ifAnd($type) == true) ? $this->getBtn2($type) : null;
	            $pop['route'] = (ifAnd($type) == true) ? $this->getUrls($type) : null;
	            $pop['route2'] = (ifAnd($type) == true) ? $this->getUrls2($type) : null;
	            $pop['id'] = (ifAnd($type) == true) ? $this->getVals($type) : null;
	            $pop['id2'] = (ifAnd($type) == true) ? $this->getVals2($type) : null;

            return response()->json($pop);

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getBtn($type) {
        try{
        	switch ($type) {
        		case 'Providers':
        			$param['type'] = ['Gonernment','Private','Self Employment'];
            		return response()->json($param);
            		break;

            	case 'Seekers':
        			$param['type'] = ['HSCC','ATT','Units'];
            		return response()->json($param);
            		break;
        		
        		default:
        			$param['type'] = null;
        			return response()->json($param);
        			break;
        	}

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getBtn2($type) {
        try{
        	switch ($type) {
        		case 'Providers':
        			$param['type'] = ['Gonernment','Private','Self Employment'];
            		return response()->json($param);
            		break;

        		case 'Seekers':
        			$param['type'] = ['Community','Non Community'];
            		return response()->json($param);
            		break;

        		default:
        			$param['type'] = null;
        			return response()->json($param);
        			break;
        	}

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUrls($type) {
        try{
        	switch ($type) {
        		case 'Providers':
        			$param['type'] = [null,null,null];
            		return response()->json($param);
            		break;

            	case 'Seekers':
        			$param['type'] = [null,null,null];
            		return response()->json($param);
            		break;
        		
        		default:
        			$param['type'] = null;
        			return response()->json($param);
        			break;
        	}

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUrls2($type) {
        try{
        	switch ($type) {
        		case 'Providers':
        			$param['type'] = [null,null,null];
            		return response()->json($param);
            		break;

            	case 'Seekers':
        			$param['type'] = [null,null];
            		return response()->json($param);
            		break;
        		
        		default:
        			$param['type'] = null;
        			return response()->json($param);
        			break;
        	}

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getVals($type) {
        try{
        	switch ($type) {
        		case 'Providers':
        			$param['type'] = [null,null,null];
            		return response()->json($param);
            		break;

            	case 'Seekers':
        			$param['type'] = [null,null,null];
            		return response()->json($param);
            		break;
        		
        		default:
        			$param['type'] = null;
        			return response()->json($param);
        			break;
        	}

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getVals2($type) {
        try{
        	switch ($type) {
        		case 'Providers':
        			$param['type'] = [null,null,null];
            		return response()->json($param);
            		break;

            	case 'Seekers':
        			$param['type'] = [null,null];
            		return response()->json($param);
            		break;
        		
        		default:
        			$param['type'] = null;
        			return response()->json($param);
        			break;
        	}

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getsId($route, $type, $pCat, $unit = '',$id = '') {
        try{
              switch ($route) {
                case 'viewFamiliesPage':
                    return [encrypt($type), encrypt($pCat),encrypt($this->fParam3($pCat)),encrypt(1),encrypt("Families")];
                    break;

                case 'viewMembers': 
                    return [encrypt($type), encrypt($pCat),encrypt($this->fParam3($pCat)),encrypt(1),($type == 'ATT' ||$pCat == 'Staffs') ? encrypt("Staffs") : encrypt("Members"),encrypt(ifAnd($unit) ? $unit : 1)]; 
                    break;

                case 'viewStudentsInfo':
                    return [encrypt($type), encrypt($pCat),encrypt($this->fParam3($pCat)),encrypt(1),encrypt("Students")];
                    break;

                case 'showFamiliesProfiles':
                    return [encrypt($id),encrypt($type), encrypt($pCat),encrypt($this->fParam3($pCat)),encrypt(1),encrypt("Families")];
                    break;
                
                default :
                    return null;
                    break;
              }

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function getServiceTitle($val)
    {
        try {
            switch ($val) {
                case 'food':
                    return 'Food';
                    break;

                case 'self-reliant':
                    return 'Self-Reliant';
                    break;

                case 'health':
                    return 'Health';
                    break;

                case 'education':
                    return 'Education';
                    break;

                case 'infrastructure':
                    return 'Infrastructure';
                    break;
                
                default:
                    return null;
                    break;
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
