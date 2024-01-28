<?php

namespace App\Http\Controllers;

use App\Models\report_category;
use Illuminate\Http\Request;

class ReportCategoryController extends Controller
{
    public function index(){
        $report_category = report_category::all();
        return view('reportCategories.index', ['report_category' => $report_category]);
        
    }

    
    public function create(){
        $report_category = report_category::all();
        return view('reportCategories.create', ['report_category' => $report_category]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'category_name' => 'required'
        
        ]);
        // dd($data);
        $newCategory = report_category::create($data);
        return redirect((route(('reportCategories.index'))))->with('sucess', 'Category Added Successfully !');;
    }

    public function edit(report_category $report_category){
        return view('reportCategories.edit', ['report_category' => $report_category]);
    }

    public function update(report_category $report_category, Request $request){
        $data = $request->validate([
            'category_name' => 'required'
        ]);

        $report_category->update(($data));
        return redirect(route('reportCategories.index'))->with('sucess', 'Category Updated Successfully');
    }

    public function destroy(report_category $report_category){
        $report_category->delete();
        return redirect(route('reportCategories.index'))->with('success', 'Category Deleted Successfully');
    }

}
