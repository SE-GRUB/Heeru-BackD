<?php

namespace App\Http\Controllers;

use App\Models\program;
use App\Models\report_category;
use App\Models\reports;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $today = Carbon::now()->toDateString();

        $programs = program::where('end_date', '>=', $today)->get();
        $report_categories = report_category::all()->sortByDesc('weight');
        return view('dashboard.index', ['programs' => $programs], ['report_categories' =>  $report_categories]);
    }

    public function view(Request $request, $program_id, $report_category){
        $reports = DB::table('reports')
            ->join('users', 'reports.user_id', '=', 'users.id')
            ->where('users.program_id', '=', $program_id)
            ->where('reports.category_id', "=", $report_category)
            ->select('reports.*')
            ->orderBy('reports.created_at', 'asc')
            ->get();

        return view('dashboard.view', ['reports' => $reports], ['category_name' => $request['category_name']]);
    }    

    public function detail(reports $report){
        return view('dashboard.detail', ['report' => $report]);
    }
}
