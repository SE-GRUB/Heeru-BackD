<?php

namespace App\Http\Controllers;

use App\Models\reports;
use App\Models\status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(){
        $status = status::all();
        return view('status.index', ['status' => $status]);
    }

    public function create(){
        $reports = reports::all();
        return view('status.create', ['reports' => $reports]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'report_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            'note' => 'required',
        ]);
        $report = reports::where('reports.id', '=', $data['report_id'])->first();
        if ($data['status'] === 'done') {
            $report->update(['isDone' => true]);
        }
        $newStatus = Status::create($data);

        return redirect()->back()->with('success', 'Status added successfully!');
    }



    public function edit(status $status){
        $reports = reports::all();
        return view('status.edit', ['reports' => $reports], ['status' => $status]);
    }

    public function update(Request $request, status $status){
        // dd($request);
        $data = $request->validate([
            'report_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            'note' => 'required',
        ]);
        // dd($data);
        $report = reports::where('reports.id', '=', $data['report_id'])->first();
        if ($data['status'] === 'done') {
            $report->update(['isDone' => true]);
        }
        $status->update(($data));
       
        return redirect(route('status.index', ['status' => $status]))->with('success', 'Status Updated Successfully !');;
    }

    public function destroy(status $status){
        $status->delete();
        return redirect(route('status.index'))->with('success', 'Status Deleted Successfully');
    }
}


