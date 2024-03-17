<?php

namespace App\Http\Controllers;

use App\Models\report_category;
use App\Models\reports;
use App\Models\status;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(report_category $report_categories){
        $reports = reports::select('reports.*')
            ->join('report_categories', 'reports.category_id', '=', 'report_categories.id')
            ->orderByDesc('report_categories.weight')
            ->get();
        return view('report.index', ['reports' => $reports, 'report_categories' => $report_categories]);
    }

    public function create(){
        $report_categories = report_category::all()->sortByDesc('weight');
        $users = User::where('role', 'student')->get();
        return view('report.create', ['report_categories' => $report_categories, 'users'=>$users]);
    }

    private function generateReportId(){
        $timestamp = microtime();
        $randomPart = strtoupper(substr(hash('sha256', $timestamp), 0, 8));
        $reportId = 'RPT-' . $randomPart; 
        return $reportId;
    }
    

    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required',
            'evidence'=> 'required',
            'w1' => 'required',
            'w2' => 'required',
            'w3' => 'required',
            'w4' => 'required',
            'w5' => 'required',
            'h1' => 'required',
            'category_id' => 'required',
            'user_id' => 'required'
        ]);
        // dd($data);
        $data['isDone']=false;
        $data['details'] = json_encode([
            'w1' => $data['w1'],
            'w2' => $data['w2'],
            'w3' => $data['w3'],
            'w4' => $data['w4'],
            'w5' => $data['w5'],
            'h1' => $data['h1'],
        ]);

        unset($data['w1'], $data['w2'], $data['w3'], $data['w4'], $data['w5'], $data['h1']);
        $data['report_id'] = $this->generateReportId();
        $newReport = reports::create($data);
        $data2 = [
            'report_id' => $newReport->id,
            'user_id' => $newReport->user_id,
            'status' => 'sent',
            'note' => 'laporan berhasil dibuat',
        ];
        // dd($data);
        $newstatus= status::create($data2);
        return redirect(route('report.index'))->with('success', 'Report Added Successfully');
    }

    private function uploadedFiles($files, $path) {
        $time = time();
        $newUrls = [];
    
        foreach ($files as $file) {
            if ($file->isValid()) {
                $fileName = $time . '_' . $file->getClientOriginalName();
                $file->move($path, $fileName);
                $newUrls[] = $path . '/' . $fileName;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload file',
                    'error' => 'File upload failed',
                ]);
            }
        }
    
        return $newUrls;
    }
    

    private function uploadedfile0($img, $path) {
        $time=time();
        $newurl=[];
        // dd($img);
        $imag=$img;
        if ($imag->isValid()) {
            $imag->move($path, $time . '_' . $imag->getClientOriginalName());
            $newurl[] = $path . '/' . $time . '_' . $imag->getClientOriginalName();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file',
                'error' => 'File upload failed',
            ]);
        }
        // dd($newurl);
        return $newurl;
    }


    public function create_report(Request $request){
        // dd($request->file('post'));
        $data = $request->validate([
            'title' => 'required',
            'details' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'evidence.*' => 'required',
        ]);

        try {
            $newReport = reports::create([
                'report_id' => $this->generateReportId(),
                'title' => $data['title'],
                'details' => $data['details'],
                'category_id' => $data['category_id'],
                'user_id' => $data['user_id'],
            ]);

            $files = $request->file('evidence');
            $path = 'report_evidences/' . $newReport->id;
            $paths = $this->uploadedFiles($files, $path);


            $evidencePath = json_encode($paths);

            $newReport->update(['evidence' => $evidencePath]);

            $newStatus = status::create([
                'report_id' => $newReport->id,
                'user_id' => $newReport->user_id,
                'status' => 'sent',
                'note' => 'laporan berhasil dibuat',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Report created successfully',
                'data' => [
                    'status' => $newStatus,
                ],
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to create report. Please try again later.',
            ]);
        }
    }


    public function edit(reports $report){
        $report_categories = report_category::all()->sortByDesc('weight');
        $users = User::where('role', 'student')->get();
        return view('report.edit', ['report' => $report, 'users' => $users], ['report_categories' => $report_categories]);
    }
  
    public function update(reports $report, Request $request){
        $data = $request->validate([
            'title' => 'required',
            'evidence'=> 'required',
            'category_id' => 'required',
            'w1' => 'required',
            'w2' => 'required',
            'w3' => 'required',
            'w4' => 'required',
            'w5' => 'required',
            'h1' => 'required',
            'user_id' => 'required'
        ]);

        $data['details'] = json_encode([
            'w1' => $data['w1'],
            'w2' => $data['w2'],
            'w3' => $data['w3'],
            'w4' => $data['w4'],
            'w5' => $data['w5'],
            'h1' => $data['h1'],
        ]);

        unset($data['w1'], $data['w2'], $data['w3'], $data['w4'], $data['w5'], $data['h1']);
        $report->update(($data));
        return redirect(route('report.index'))->with('success', 'Report Updated Successfully');
    }

    public function destroy(reports $report){
        // dd($report);
        status::where('report_id', $report->id)->delete(); 
        $report->delete();
        return redirect(route('report.index'))->with('success', 'Report Deleted Successfully');
    }

    public function riwayatOngoing(Request $request){
        try {
            $reports = reports::select('reports.id', 'reports.title', 'reports.isProcess', 'reports.created_at')
                ->orderByDesc('reports.created_at')
                ->where('reports.isDone', '=', false)
                ->where('reports.user_id', '=', $request->input('user_id'))
                ->get();
                
            return response()->json([
                'success' => true,
                'message' => 'Fetched ongoing reports!',
                'reports' => $reports
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => False,
                'message' => 'Internal server error',
                'error' => $th->getMessage()
            ]);
        }
    }
    public function riwayatDone(Request $request){
        try {
            $reports = reports::select('reports.id', 'reports.title', 'reports.created_at')
                ->orderByDesc('reports.created_at')
                ->where('reports.isProcess', '=', true)
                ->where('reports.isDone', '=', true)
                ->where('reports.user_id', '=', $request->input('user_id'))
                ->get();
                
            return response()->json([
                'success' => true,
                'message' => 'Fetched done reports!',
                'reports' => $reports
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => False,
                'message' => 'Internal server error',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function riwayatDetail(Request $request){
        try {
            $report = reports::where('reports.id', '=', $request->input('report_id'))->first();
            $report_category = report_category::where("report_categories.id", '=', $report->category_id)->first();
            $status = status::where('status.report_id', '=', $report->id)->orderBy('created_at', 'desc')->first();
            $user = User::where('users.id','=', $report->user_id)->first();

            $created_at = $report->created_at;
            $datetime = new DateTime($created_at);
            $formatted_date = $datetime->format('j F Y');
                
            return response()->json([
                'success' => true,
                'message' => 'Fetched report details!',
                'report' => [
                    'report_id' => $report->report_id,
                    'status' => $status->status,
                    'name' => $user->name,
                    'no_telp' => $user->no_telp,
                    'email' => $user->email,
                    'report_category' => $report_category->category_name,
                    'report_date' => $formatted_date,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => False,
                'message' => 'Internal server error',
                'error' => $th->getMessage()
            ]);
        }
    }
}
