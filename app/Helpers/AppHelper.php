<?php 
function ifAnd($statement){
    return $statement != null || $statement != '' || $statement != 0;
}

function ifEqual($statement){
    return $statement == null || $statement == 0 || $statement == '';
}

function condition(array $data,$statement){
    return (ifAnd($statement) == true ) ? $data[$statement] != null || $data[$statement] != '' : false;
}

function checkZero(array $data,$statement){
    return $data[$statement] != null || $data[$statement] != 0;
}

function conditions(array $data,$cat){

   return (ifAnd($cat) == true ) ? ($data[$cat] != null || $data[$cat] != '') ? 'Member' : 'Head' : 'Head';
}

function condition2(array $data,$cat,$cat2){
   return ($data[$cat] == null || $data[$cat] == '') ? conditions($data,$cat2) : 'Member';
}

function condition3(array $data, $cat, $cat2, $cat3){
   return ($data[$cat] == null || $data[$cat] == '') ? condition2($data,$cat2,$cat3) : 'Member';
}

function condition4(array $data, $cat, $cat2, $cat3, $cat4){
   return ($data[$cat] == null || $data[$cat] == '') ? condition3($data,$cat2,$cat3,$cat4) : 'Member';
}

function key_find(array $data, $var){
	try {
	      return (array_key_exists($var,$data) == true) ? $var : null;

	} catch (Exception $e) {
	    return $e->getMessage();
	}
}

# families global functions

function getProper($data,$param)
{
    try { return $data[0]->$param; } catch (Exception $e) { return $e->getMessage(); }
}

function getByNum($data,$param,$num)
{
    try { return $data[$num]->$param; } catch (Exception $e) { return $e->getMessage(); }
}

function getSubHead($relation,$id,$hid){
    return $hid !== $id && $relation == 'Mother' || $relation == 'Father';
}

function getFamiliesMains($relation){
    return $relation == 'Wife' || $relation == 'Husband' || $relation == 'Mother' || $relation == 'Father' || $relation == 'Guaradian';
}

function onlyFamilySubMainss($relation){
    return $relation == 'HeadMother' || $relation == 'HeadFather' || $relation == 'Guaradian';
}

function getImgFileName($path_str,$pic_type,$ext){
    return getStr($pic_type).'_'.$path_str.'_'.mt_rand(7,7999999).'.'.$ext;
}

function getHfidFieldName($type){
    switch ($type) {
      case 'Adhar':
          return 'hfid';
          break;

       default:
          return 'hfid_link';
          break;
    }
}

function getPersonIdField($type){
    switch ($type) {
      case 'Ration':
          return 'fam_id';
          break;

      case 'Marks':
          return 'student_id';
          break;
       
       default:
          return 'id';
          break;
    }
}

function getImagePath($path_cat,$type,$hfid,$picType ='')
{
   try {
      switch ($path_cat) {
         case 'Doc':
             return getDocPath($type,$hfid,$picType);
           break;

         case 'FamProfile':
             return getFamProfilePath($type,$hfid);
           break;

         case 'OrgProfile':
             return getOrgProfilePath($type,$hfid);
           break;

         default:
            return null;
            break;
      }

   } catch (Exception $e) { return $e->getMessage(); }
 }

function getDocPath($type,$hfid,$picType)
{
   try {
      switch ($type) {
         case 'HSCC':
            switch ($picType) {
              case 'Adhar':
                  return '/adminAssets/images/FamiliesProfile/HSCC/'.$hfid.'/documents/adhar_card/';
                break;

              case 'Ration':
                  return '/adminAssets/images/FamiliesProfile/HSCC/'.$hfid.'/documents/ration_card/';
                break;

              case 'Marks':
                  return '/adminAssets/images/FamiliesProfile/HSCC/'.$hfid.'/documents/Marks-Cards/';
                break;
              
              default:
                return null;
                break;
            }
             
           break;

         case 'MR':
            switch ($picType) {
              case 'Adhar':
                  return '/adminAssets/images/FamiliesProfile/MR/'.$hfid.'/documents/adhar_card/';
                break;

              case 'Ration':
                  return '/adminAssets/images/FamiliesProfile/MR/'.$hfid.'/documents/ration_card/';
                break;

              case 'Marks':
                  return '/adminAssets/images/FamiliesProfile/MR/'.$hfid.'/documents/marks_card/';
                break;
              
              default:
                return null;
                break;
            }
           break;

         default:
            return null;
            break;         
      }

   } catch (Exception $e) { return $e->getMessage(); }
}

function getFamProfilePath($type,$hfid)
{
   try {
      switch ($type) {
         case 'HSCC':
            return '/adminAssets/images/FamiliesProfile/HSCC/'.$hfid.'/profile/';
            break;

         case 'MR':
            return '/adminAssets/images/FamiliesProfile/MR/'.$hfid.'/profile/';
            break;

         default:
            return null;
            break;         
      }

   } catch (Exception $e) { return $e->getMessage(); }
}

function getStr($type)
{
   try {
      switch ($type) {
         case 'Ration':
            return 'RATION';
            break;

         case 'Adhar':
            return 'ADHAR';
            break;

         case 'Profile':
            return 'PIC';
            break;

        case 'Marks':
            return 'MARKS';
            break;

         default:
            return '';
            break;         
      }

   } catch (Exception $e) { return $e->getMessage(); }
}

// function sizeImg($type)
// {
//    try {
//       switch ($type) {
//          case 'Ration':
//             return 800,400;
//             break;

//          case 'Adhar':
//             return 800,400;
//             break;

//          case 'Profile':
//             return 800,400;
//             break;

//          default:
//             return '';
//             break;         
//       }

//    } catch (Exception $e) { return $e->getMessage(); }
// }

function getOtherImagePath($str,$type,$picType)
{
   try {

      switch ($type) {

            case 'ATTStaff':
                return '/adminAssets/images/OrganizationsProfile/ATT/Staffs/';
              break;

            case 'HFATT':
                return '/adminAssets/images/OrganizationsProfile/ATT/Student/';
              break;

            case 'HFDBS':
                return '/adminAssets/images/OrganizationsProfile/ATT/Student/';
              break;

            case 'HFWAS':
                return '/adminAssets/images/OrganizationsProfile/ATT/Student/';
              break;
            
            default:
                return null;
              break;
         
      }

   } catch (Exception $e) {
      return $e->getMessage();
   }
}

