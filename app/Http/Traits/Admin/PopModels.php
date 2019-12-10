<?php
namespace App\Http\Traits\Admin;

use Illuminate\Http\Request;
use DB;
use Crypt;

trait PopModels {

	public function popsUpData($type) {
        try{
            
        	switch ($type) {
        		case 'Supply':
            		$mod['t'] = $this->getButton('Supply',$this->getsParam('Monthly','HSCC','MR'),$this->getsParam('Ramadan','Eid','Ramadan',"Other"));
            		$mod['r'] = [['viewFamiliesPage','viewFamiliesPage'], null];
            		$mod['i'] = [['HSCC','MR'], null];
            		$mod['pCat'] = 'Food';
            		$mod['clr'] = "#e7b91b";

            		return response()->json($mod);
            		break;

            	case 'Providers':
            		$mod['t'] = $this->getButton('Providers or Employers',$this->getsParam('Indian','Gonernment','Private','Self Employment'),$this->getsParam('Oversease','Gonernment','Private',"Self Employment"));
            		$mod['i'] = null;
            		$mod['r'] = null;
            		$mod['pCat'] = 'Reliance';
            		$mod['clr'] = "#00bcd4";

            		return response()->json($mod);
            		break;

            	case 'Seekers':
            		$mod['t'] = $this->getButton('Job Seekers',$this->getsParam('In House','HSCC','ATT','Units'),$this->getsParam('Outsourcing','Community','Non Community'));
            		$mod['i'] = null;
            		$mod['r'] = null;
            		$mod['pCat'] = 'Reliance';
            		$mod['clr'] = "#00bcd4";

            		return response()->json($mod);
            		break;

            	case 'Awarness':
            		$mod['t'] = $this->getButton('Awarness','Food Campaign'); // buttons and their titles
            		$mod['i'] = null;
            		$mod['r'] = null; // routes
            		$mod['pCat'] = 'Food'; // project Category
            		$mod['clr'] = "#e7b91b"; // choose colour

            		return response()->json($mod);
            		break;

            	case 'Prevention':
            		$mod['t'] = $this->getButton('Prevention','Rural','Urban');
            		$mod['i'] = null;
            		$mod['r'] = null;
            		$mod['pCat'] = 'Health';
            		$mod['clr'] = "#f12020";

            		return response()->json($mod);
            		break;

            	case 'Cure':
            		$mod['t'] = $this->getButton('Cure','Rural','Urban');
            		$mod['i'] = null;
            		$mod['r'] = null;
            		$mod['pCat'] = 'Health';
            		$mod['clr'] = "#f12020";

            		return response()->json($mod);
            		break;

            	case 'Data':
            		$mod['t'] = $this->getButton('Data','Rural','Urban');
            		$mod['i'] = null;
            		$mod['r'] = null;
            		$mod['pCat'] = 'Health';
            		$mod['clr'] = "#f12020";

            		return response()->json($mod);
            		break;

            	case 'Colony':
            		$mod['t'] = $this->getButton('HSCC Colony','HSCC Families','HSCC Students');
            		$mod['i'] = ['HSCC',null];
            		$mod['r'] = ['viewFamiliesPage',null];
            		$mod['pCat'] = 'Infrastructure';
            		$mod['clr'] = "#5dce8f";

            		return response()->json($mod);
            		break;

            	case 'Parents':
            		$mod['t'] = $this->getButton('Parents Info','ATT Parents Info','Workshop Parents Info','Other');
            		$mod['i'] = null;
            		$mod['r'] = null;
            		$mod['pCat'] = 'Education';
            		$mod['clr'] = "#4caf50";

            		return response()->json($mod);
            		break;

            	case 'Teachers':
            		$mod['t'] = $this->getButton('Teachers Info','ATT Staff Info','ATT Trained Teachers Info','Other Institution');
            		$mod['r'] = ['viewMembers',null,null];
            		$mod['i'] = ['ATT',null,null];
            		$mod['pCat'] = 'Education';
            		$mod['clr'] = "#4caf50";

            		return response()->json($mod);
            		break;

            	case 'School':
            		$mod['t'] = $this->getButton('School Management','CBSE','State','Other');
            		$mod['i'] = null;
            		$mod['r'] = null;
            		$mod['pCat'] = 'Education';
            		$mod['clr'] = "#4caf50";

            		return response()->json($mod);
            		break;

            	case 'Resource':
            		$mod['t'] = $this->getButton('Resource Persons','Counsellors','Professionals','Career Guidance');
            		$mod['i'] = null;
            		$mod['r'] = null;
            		$mod['pCat'] = 'Education';
            		$mod['clr'] = "#4caf50";

            		return response()->json($mod);
            		break;
        		
        		default:
            		return null;
        			break;
        	}

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

	public function getsParam($title, $btn, $btn2 = '', $btn3 = '') {
        try{

        	$pop['title'] = (ifAnd($title) == true) ? $title : '';
	       	$pop['btn'] = array_filter([$btn, (ifAnd($btn2) == true) ? $btn2 : '', (ifAnd($btn3) == true) ? $btn3 : '']);

            return response()->json($pop);

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getButton($title, $btn, $btn2 = '',$btn3 = '') {
        try{
	          return $this->getsParam($title, $btn, ifAnd($btn2) ? $btn2 : null, ifAnd($btn3) ? $btn3 : null);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function fParam($type) {
        try{
	          switch ($type) {
	          	case 'HSCC':
	          		return "HSCC";
	          		break;

	          	case 'MR':
	          		return "MR";
	          		break;

	          	case 'HSCC Families':
	          		return "HSCC";
	          		break;

	          	case 'ATT Staff Info':
	          		return "ATT";
	          		break;
	          	
	          	default:
	          		return null;
	          		break;
	          }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function fParam3($type) {
        try{
	          switch ($type) {
	          	case 'Food':
	          		return "Projects";
	          		break;

	          	case 'Reliance':
	          		return "Projects";
	          		break;

	          	case 'Health':
	          		return "Projects";
	          		break;

	          	case 'Infrastructure':
	          		return "Projects";
	          		break;

	          	case 'Education':
	          		return "Projects";
	          		break;
	          	
	          	default:
	          		return 'Organization';
	          		break;
	          }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPClass($type) {
        try{
	          switch ($type) {
	          	case 'Food':
	          		return "food-link border-color2";
	          		break;

	          	case 'Reliance':
	          		return "reliance-link border-color4";
	          		break;

	          	case 'Health':
	          		return "health-link border-color3";
	          		break;

	          	case 'Infrastructure':
	          		return "infra-link border-color5";
	          		break;

	          	case 'Education':
	          		return "edu-link border-color";
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