<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use File;
use Image;

trait UplaodImage
{
    /**
     * File upload function.
     *
     * @return name
     */
    public function saveImage($request,$path,$img_name,$path_str,$pic_type){
        try {
            if (ifAnd($request->$img_name)) {
                # validating the image
                $this->imgValidate($request,$img_name);

                if ($request->has($img_name)) {
                    # getting file extension
                    $ext = $request->file($img_name)->extension();
                    # getting file name
                    $filename = getImgFileName($path_str,$pic_type,$ext);

                    if (!File::exists(storage_path($path))) {
                        # creating the directory for the path
                        File::makeDirectory(public_path().$path, 0775, true, true); }

                    # resizing and saving the image 
                    Image::make($request->file($img_name))->save(public_path().$path.$filename);

                    return $filename;
                }
            }

        } catch (Exception $e) { return $e->getMessage(); }
    }

    public function existsImg($model,$feild,$id,$hfid,$hfidField){
        try {
            return DB::table($model)->select($feild)->where('id','=',$id)->where($hfidField ,'=',$hfid)->where('status','=',1)->get();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function imgValidate($request,$feild){
        try {

            return $request->validate([ $feild => 'required|image|mimes:jpeg,png,jpg,gif|max:250']);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Updationg image.
     *
     * @return updated image. if exists, old one.
     */
    public function getOriginalImage($request,$path,$img_name,$path_cat,$pic_type,$hfid,$id,$model)
    {
        try {   
            # find the database images that previously feeded...
            $hfidField = getHfidFieldName($pic_type);
            // dd($hfidField);
            # checking for the existing image...
            $imgs = $this->existsImg($model,$img_name,$id,$hfid,$hfidField);
            // dd($request->$img_name);
            return  ifAnd(count($imgs)) ? ifAnd($request->$img_name) ? $this->saveImage($request,$path,$img_name,$hfid,$pic_type) : $this->getProper($imgs,$img_name) : $this->saveImage($request,$path,$img_name,$hfid,$pic_type);

        } catch (Exception $e) { return $e->getMessage(); }
    }

    protected function getImgName($type)
    {
        try {
            switch ($type) {
                case 'Ration':
                    return 'ration_image';
                    break;

                case 'Adhar':
                    return 'adhar_image';
                    break;

                case 'Profile':
                    return 'image';
                    break;

                case 'Marks':
                    return 'marks_img';
                    break;
                
                default:
                    return null;
                    break;
            }
            
        } catch (Exception $e) { return $e->getMessage(); }
    }


    // public function getOriginalImage($img,$path,$name,$fieldName,$id,$model)
    // {
    //     try {
    //         # find the database images that previously feeded...
            
    //         DB::table($model)->select($feild)->where('id','=',$id)->where('status','=',1)->get();

    //         return  (ifAnd(count($imgs)) == true) ? 
    //                     (ifAnd($img) == true ) ? 
    //                         ($name.'_'.$img->getClientOriginalName() != $imgs[0]->$fieldName) ? 
    //                             $this->saveImage($img,$path,$name) 
    //                         : $imgs[0]->$fieldName 

    //                     : $imgs[0]->$fieldName 

    //                 : $this->saveImage($img,$path,$name);

    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
}
