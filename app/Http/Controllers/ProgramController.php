<?php

namespace App\Http\Controllers;

use App\Models\program;
use App\Models\User;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(){
        $programs = program::all();
        return view('program.index', ['programs' => $programs]);
        
    }

    public function create(){
        $pics = User::where('role', 'pic')->get();
        return view('program.create', ['pics' => $pics]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'program_name' => 'required',
            'pic_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        $newProgram = program::create($data);
        return redirect((route(('program.index'))))->with('success', 'Program Added Successfully !');;
    }


    public function edit(program $program){
        $pics = User::where('role', 'pic')->get();
        return view('program.edit', ['program' => $program], ['pics' => $pics]);
    }

    public function update(program $program, Request $request){
        $data = $request->validate([
            'program_name' => 'required',
            'pic_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $program->update(($data));
        return redirect(route('program.index'))->with('success', 'Program Updated Successfully');
    }

    public function destroy(program $program){
        $program->delete();
        return redirect(route('program.index'))->with('success', 'Program Deleted Successfully');
    }
}
