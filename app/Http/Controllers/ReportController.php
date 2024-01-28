<?php

namespace App\Http\Controllers;

use App\Models\report_category;
use App\Models\reports;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $reports = reports::all();
        return view('report.index', ['reports' => $reports]);
        
    }

    public function create(){
        $report_categories = report_category::all();
        return view('report.create', ['report_categories' => $report_categories]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required',
            'evidence'=> 'required',
            'category_id' => 'required'
            
        ]);
        // dd($data);
        $newCategory = reports::create($data);
        return redirect((route(('report.index'))))->with('sucess', 'report Added Successfully !');;
    }

    public function edit(reports $report){
        return view('report.edit', ['report' => $report]);
    }

    public function update(reports $report, Request $request){
        $data = $request->validate([
            'title' => 'required',
            'evidence'=> 'required',
            'category_id' => 'required'
        ]);

        $report->update(($data));
        return redirect(route('report.index'))->with('sucess', 'report Updated Successfully');
    }

    public function destroy(reports $report){
        $report->delete();
        return redirect(route('report.index'))->with('success', 'report Deleted Successfully');
    }
}
