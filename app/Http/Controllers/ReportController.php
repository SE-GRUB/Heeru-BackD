<?php

namespace App\Http\Controllers;

use App\Models\reports;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class ReportController extends Controller
{
    public function index(){
        $reports = reports::all();
        return view('report.index', ['reports' => $reports]);
        
    }

    public function create(){
        $reports = reports::all();
        return view('report.create', ['programs' => $reports]);
    }
}
