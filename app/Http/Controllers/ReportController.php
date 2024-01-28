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
}
