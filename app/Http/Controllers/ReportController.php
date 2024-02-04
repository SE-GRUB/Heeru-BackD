<?php

namespace App\Http\Controllers;

use App\Models\report_category;
use App\Models\reports;
use App\Models\status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    private function uploadedfile($img,$path) {
        $time=time();
        $newurl=[];
        foreach ($img as $key => $imag) {
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
        }
        return $newurl;
    }

    public function create_report(Request $request){  
        $data = $request->validate([
            'title' => 'required',
            'details' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'evidence.*' => 'required',
        ]);

        try {
            $base64FileContent = $request->input('evidence');
            $decodedFileContent = base64_decode($base64FileContent);

            $data['evidence']  = $this->uploadedfile($decodedFileContent,'report_evidences/'. $data['category_id']);

            $newReport = reports::create($data);

            $data2 = [
                'report_id' => $newReport->id,
                'user_id' => $newReport->user_id,
                'status' => 'sent',
                'note' => 'laporan berhasil dibuat',
            ];

            $newStatus = status::create($data2);

            return response()->json([
                'success' => true,
                'message' => 'Report created successfully',
                'data' => [
                    'report' => $newReport,
                    'status' => $newStatus,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create report',
                'error' => $e->getMessage(),
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
        $report->delete();
        return redirect(route('report.index'))->with('success', 'Report Deleted Successfully');
    }
}
