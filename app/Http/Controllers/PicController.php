<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PicController extends Controller
{
    public function ceknip(Request $request)
    {
     $data=DB::table('students')->where('nip','=',$request->nip)->join('users','students.user_id','=','users.id');
     $valid=$data->count();
     if ($valid!=0) {
        $data=$data->first();
        $return =["NIP"=> $data->nip,"NOMOR"=>$data->no_telp];
        return response()->json(['code'=>200,'message'=>'NIP ditemukan','data'=>$return]);
     }else{
        return response()->json(['code'=>409,'message'=>'NIP tidak ditemukan']);
     }
    }
}
