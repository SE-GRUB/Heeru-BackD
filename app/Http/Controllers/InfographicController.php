<?php

namespace App\Http\Controllers;

use App\Models\infographic;
use App\Models\infographic_image;
use Illuminate\Http\Request;

class InfographicController extends Controller
{
    public function index(){
        $infographics = infographic::all();
        return view('infographic.index', ['infographics' => $infographics]);
        
    }

    public function create(){
        return view('infographic.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required'
        ]);
        $newInfographic = infographic::create($data);
        // $infographic_id = $newInfographic['id'];
        $data_image = $request->validate([
            'infographic_images.*' => 'required' 
        ]);
        // dd($data_image);
        foreach ($request->file('infographic_images') as $image) {
            $path = $image->store('infographic_image', 'public');
            $info_image_data = [$newInfographic->id, $path];
            $newInfographicFile = infographic_image::create($info_image_data);
            // $newInfographicFile = new infographic_image([
            //     'infographic_id' => $newInfographic->id,
            //     'image_path' => $path
            // ]);
            // $newInfographicFile->save();
        }

        return redirect((route(('infographic.index'))))->with('success', 'Infographic Added Successfully !');;
    }


    public function edit(infographic $infographic){
        return view('infographic.edit', ['infographic' => $infographic]);
    }

    public function update(infographic $infographic, Request $request){
        $data = $request->validate([
            'title' => 'required'
        ]);

        $infographic->update(($data));
        return redirect(route('infographic.index'))->with('success', 'Infographic Updated Successfully');
    }

    public function destroy(infographic $infographic){
        $infographic->delete();
        return redirect(route('infographic.index'))->with('success', 'Infographic Deleted Successfully');
    }
}
