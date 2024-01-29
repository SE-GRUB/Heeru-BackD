<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function patup(Request $request)
    {
        $event = $request->idconst;
        $message = $request->message;
        $target = $request->idtarget;
        // dd($event, $message, $target);
        try {
            $setnew = DB::table('chats')->insert([
                'consultation_id' => $event,
                'message' => $message,
                'isRead' => false,
                'target_id' => $target,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return response()->json(['success' => $setnew],200);
        } catch (\Throwable $th) {
            return response()->json(['failed' => "Ini ada masalah"],500);
        }
    }

    public function patdown(Request $request){
        $allmassage = DB::table('chats')->where('consultation_id', $request->idconst);
        $data=$allmassage->orderBy('updated_at', 'asc')->get();
        // dd($data);
        $userlist=$allmassage->select('target_id')->distinct()->get();
        // dd($userlist);
        $pesan;
        foreach ($data as $key => $value) {
            $pesan[$key] = ["Pesan"=>$value->message, "isRead"=>$value->isRead, "target_id"=>$value->target_id, "updated_at"=>$value->updated_at];
        }
        // dd($pesan);
        return response()->json(['pesan' => $pesan,"listUser"=>$userlist],200);
    }
}
