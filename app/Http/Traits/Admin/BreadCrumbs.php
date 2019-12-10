<?php
namespace App\Http\Traits\Admin;

use Illuminate\Http\Request;
use DB;
use Crypt;

trait BreadCrumbs {

    public function breadCrumbsData($type,$prType,$currPage,$personcat,$page,$status,$unitId = '',$subPage = '') {
        try{
            # find the possible titles for the breadcrum title...
            $title = $this->getBCTitle($type,$currPage,$personcat,$page,$this->getUnitName($unitId),$subPage);
            # find all routes for the breadcrumb...
            $routes = $this->getBCRoutes($page,$personcat,ifAnd($subPage) ? $subPage : ''); 

            return $this->SETBREADCRUMBS($type,$prType,$currPage,$title,$routes,$unitId,ifAnd($subPage) ? $subPage : '');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function SETBREADCRUMBS($type,$prType,$currPage,$title,$routes,$unit = '',$subPage = '') {
        try{
            echo '<div class="d-flex">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="'.route('projectPage').'">Home</a></li>
                      <li class="breadcrumb-item"><a href="'.route($routes->getData()->prevRoute).'">'.$title->getData()->prevTitle.'</a></li>
                      '.(($currPage != 'view') ? '<li class="breadcrumb-item"><a href="'.route($routes->getData()->presRoute,$this->getsId($routes->getData()->presRoute, $type, $prType, $unit)).'">'.$title->getData()->presTitle.'</a></li>
                            <li class="breadcrumb-item active">'.$title->getData()->nextTitle.'</li>'
                        : '<li class="breadcrumb-item active">'.$title->getData()->presTitle.'</li>').'
                    </ol>
                </div>';

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getBCTitle($type,$currPage,$personcat,$page,$unit_name = '',$subPage = '') {
        try{
            $feed['prevTitle'] = $this->getPrevPage($page);
            $feed['presTitle'] = $this->getPresTitle($type,$personcat,$unit_name).' Info';
            $feed['nextTitle'] = $this->getNextTitle($currPage);
            $feed['upNextTitle'] = $this->getUpTitle($subPage);

            return response()->json($feed);

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPrevPage($page) {
        try{
            switch ($page) {
                case 'Projects':
                    return "Projects";
                    break;

                default:
                    return "Organization";
                    break;
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPresTitle($type,$personcat,$unit_name = '') {
        try{
        
            return $this->findTypeTitle($type).' '.$personcat.' '.$unit_name;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function findTypeTitle($type) {
        try{
        
            switch ($type) {
                case 'HSCC':
                    return "HSCC";
                    break;
                
                case 'MR':
                    return "MR";
                    break;

                case 'Youth Wing':
                    return "Youth Wing";
                    break;

                case 'ATT':
                    return "ATT";
                    break;

                case 'Womens Wing':
                    return "Women's Wing";
                    break;

                case 'Girls Wing':
                    return "Girl's Wing";
                    break;

                case 'Overseas':
                    return "Overseas";
                    break;
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getNextTitle($page = '') {
        try{

            switch ($page) {
                case 'add':
                    return "Add Informations";
                    break;

                case 'profile':
                    return "Profile Informations";
                    break;

                case 'assessments':
                    return "Add Assessments Informations";
                    break;

                default:
                    return "Informations";
                    break;
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUpTitle($page = '') {
        try{

            switch ($page) {
                case 'edit':
                    return "Edit Informations";
                    break;

                default:
                    return "Informations";
                    break;
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUnitName($unitName = '') {
        try{

            return (ifAnd($unitName) == true ) ? $this->find_field_data('unit_details','unit_name',$unitName)[0]->unit_name : '';

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getBCRoutes($page, $personcat, $subPage = '') {
        try{
            $feed['prevRoute'] = $this->getPrevRoute($page);
            $feed['presRoute'] = $this->getPresRoute($personcat);
            $feed['nextRoute'] = $this->getNextRoute($personcat);
            
            return response()->json($feed);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPrevRoute($route) {
        try{
            switch ($route) {
                case 'Projects':
                    return "projectPage";
                    break;

                case 'Organization':
                    return "OrganizationPage";
                    break;

                default:
                    return "admin-home";
                    break;
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPresRoute($route) {
        try{
            switch ($route) {
                case 'Members':
                    return "viewMembers";
                    break;

                case 'Students':
                    return "viewStudentsInfo";
                    break;

                case 'Families':
                    return "viewFamiliesPage";
                    break;
                
                default:
                    return "viewMembers";
                    break;
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getNextRoute($route) {
        try{
            switch ($route) {
                case 'Families':
                    return "showFamiliesProfiles";
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