<?php

namespace App\Http\Controllers;

use App\Models\report_category;
use App\Models\reports;
use App\Models\status;
use App\Models\User;
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
        // dd($request->file('evidence'));
        $data = $request->validate([
            'title' => 'required',
            'details' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'evidence.*' => 'required',
        ]);

        if ($request->hasFile('evidence')) {
            // Jika file ada dalam permintaan, ambil informasi file
            $files = $request->file('evidence');
            $path = 'report_evidences/' . $data['user_id'];
        
            // Simpan file dan dapatkan pathnya
            $paths = $this->uploadedFiles($files, $path);
            $pathsString = implode(', ', $paths);
        
            // Periksa apakah file berhasil diunggah
            if (count($paths) > 0) {
                return response()->json(['success' => true, 'message' => 'File berhasil diterima dan disimpan ke ' . $pathsString . '.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan file.']);
            }
        } else {
            // Jika file tidak ada dalam permintaan, kirimkan respons dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'File tidak diterima.']);
        }

        try {
            // $newReport = reports::create([
            //     'title' => $data['title'],
            //     'details' => $data['details'],
            //     'category_id' => $data['category_id'],
            //     'user_id' => $data['user_id'],
            // ]);

            // $files = $request->file('evidence');
            // $path = 'report_evidences/' . $newReport->id;
            // $paths = $this->uploadedFiles($files, $path);


            // $evidencePath = json_encode($paths);

            // $newReport->update(['evidence' => $evidencePath]);

            // $newStatus = status::create([
            //     'report_id' => $newReport->id,
            //     'user_id' => $newReport->user_id,
            //     'status' => 'sent',
            //     'note' => 'laporan berhasil dibuat',
            // ]);

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Report created successfully',
            //     'data' => [
            //         'status' => $newStatus,
            //     ],
            // ]);

            // return redirect()->back()->back()->with('success', 'Report created successfully');
        } catch (\Exception $e) {
            // \Log::error('Failed to create report: ' . $e->getMessage());

            // return response()->json([
            //     'success' => false,
            //     'message' => 'Failed to create report. Please try again later.',
            // ]);
            // return redirect()->back()->->with('error', 'Failed to create report. Please try again later.');
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
}
