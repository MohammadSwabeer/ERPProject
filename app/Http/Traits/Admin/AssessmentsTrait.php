<?php
namespace App\Http\Traits\Admin;

use Illuminate\Http\Request;
use DB;

trait AssessmentsTrait {

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SpiritualAndMadrasaId()
    {
        try {
        	return DB::table('tbl_spiritual_development AS tsd')
              ->leftJoin('tbl_madrasa_education AS tme',['tme.spiritual_id' => 'tsd.id'])
              ->select('tsd.id as spd_id', 'tme.id as mid')
              // ->groupBy('tsd.id')
              ->orderBy('tsd.id')
              ->get();

        } catch (Exception $e) { return $e->getMessage(); }
    }

    public function SpiritualId()
    {
        try {
        	return DB::table('tbl_spiritual_development AS tsd')->get('tsd.id as spd_id');

        } catch (Exception $e) { return $e->getMessage(); }
    }

    public function MadrasaId()
    {
        try {
        	return DB::table('tbl_madrasa_education AS tsd')->get('tsd.id as mid');

        } catch (Exception $e) { return $e->getMessage(); }
    }

    public function SpiritualAndMadrasaIds()
    {
        try {
        	return DB::table('tbl_spiritual_development AS tsd')
              ->leftJoin('tbl_huqooq_ibaadh AS thi',['thi.spiritual_id' => 'tsd.id'])
              ->leftJoin('tbl_huqooq_allah AS tha',['tha.spiritual_id' => 'tsd.id'])
              ->leftJoin('tbl_madrasa_education AS tme',['tme.spiritual_id' => 'tsd.id'])
              ->leftJoin('tbl_academics AS ta',['ta.madrasa_id'=>'tme.id'])
              ->leftJoin('tbl_tarbiyyah AS tt',['tt.madrasa_id'=>'tme.id'])
              ->select('tsd.is as spd_id', 'tme.id as mid', 'thi.physical', 'thi.finance', 'thi.intellectual','tha.salah', 'tha.saum', 'tha.zakath', 'tt.tajveed', 'ta.grade')
              ->get();

        } catch (Exception $e) { return $e->getMessage(); }
    }
}
