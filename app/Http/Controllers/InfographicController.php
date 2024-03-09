<?php

namespace App\Http\Controllers;

use App\Models\infographic;
use App\Models\infographic_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InfographicController extends Controller
{
    public function index(){
        $infographics = infographic::all();
        return view('infographic.index', ['infographics' => $infographics]);

    }

    public function create(){
        return view('infographic.create');
    }

    private function uploadedfile($img,$path) {
        $time=time();
        $newurl=[];
        foreach ($img as $key => $imag) {
            $imag->move($path, $time.'_'.$imag->getClientOriginalName());
            $newurl[] = $path.'/'.$time.'_'.$imag->getClientOriginalName();
        }
        return $newurl;
    }

    public function store(Request $request){

        $data = $request->validate([
            'title' => 'required',
            'infographic_images' => 'required',
            'infographic_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // simpan data ke Infographic
        $newInfographic = infographic::create($data);

        // proses gambarnya ke folder server
        $paths = $this->uploadedfile($request->file('infographic_images'),'infographic_images/'.$newInfographic->id);

        // simpan path gambarnya ke database
        foreach ($paths as $key => $path) {
            // ada perubahan di modelnya tolong di cek model lain soalnya ada typo
            infographic_image::create([
                'info_id' => $newInfographic->id,
                'image_path' => $path
            ]);
        }

        return redirect((route(('infographic.index'))))->with('success', 'Infographic Added Successfully !');;
    }


    public function edit(infographic $infographic){
        $infographic_images = infographic_image::where('info_id', $infographic->id)->get();
        return view('infographic.edit', ['infographic' => $infographic], ['infographic_images' => $infographic_images]);
    }

    public function update(infographic $infographic, Request $request){
        $data = $request->validate([
            'title' => 'required'
        ]);

        $infographic->update(($data));
        return redirect(route('infographic.index'))->with('success', 'Infographic Updated Successfully');
    }

    public function destroy(infographic $infographic){
        $infographic_images = infographic_image::where('info_id', $infographic->id)->get();
        foreach($infographic_images as $infographic_image){
            $infographic_image->delete();
        }
        $infographicFolderPath = public_path('infographic_images/' . $infographic->id);
        if (File::exists($infographicFolderPath)) {
            File::deleteDirectory($infographicFolderPath);
        }
        $infographic->delete();
        return redirect(route('infographic.index'))->with('success', 'Infographic Deleted Successfully');
    }

    public function delpo(Request $request) {
        DB::table('infographic_images')->where('id', $request->id)->delete();
        return response()->json("beres", 200);
    }

    public function showInfografis(){
        $infographics = infographic::all();
        if($infographics->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'There are no infographics registered',
            ]);
        }

        foreach ($infographics as $infographic){
            $images = infographic_image::where('info_id', $infographic->id)->get();

            if($infographic){
                
                $dataImages = [];
                if($images){
                    foreach( $images as $image){
                        $dataImages[]=[
                            'image_path' => $image->image_path,
                        ];
                    }
                }
                $dataInfographics[]=[
                    'title' => $infographic->title,
                    'images' => $dataImages,
                ];
            };
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched all counselors',
            'infographics' => $dataInfographics,
        ]);
    }
}
