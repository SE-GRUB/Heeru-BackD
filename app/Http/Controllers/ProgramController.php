<?php

namespace App\Http\Controllers;

use App\Models\program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(){
        $programs = program::all();
        return view('program.index', ['programs' => $programs]);
        
    }

    public function create(){
        return view('program.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'program_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        $newProgram = program::create($data);
        return redirect((route(('program.index'))));
    }


    public function edit(program $program){
        return view('program.edit', ['program' => $program]);
    }

    public function update(program $program, Request $request){
        $data = $request->validate([
            'program_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $program->update(($data));
        return redirect(route('program.index'))->with('sucess', 'User Updated Successfully');
    }

    public function destroy(program $program){
        $program->delete();
        return redirect(route('program.index'))->with('success', 'User Deleted Successfully');
    }
}
