@extends('backend.layout')

@section('title', 'Dashboard')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>


<ul class="nav nav-tabs">
    @foreach ($programs as $key => $program)
        @php
            $count = DB::table('reports')
                ->join('users', 'reports.user_id', '=', 'users.id')
                ->where('users.program_id', '=', $program->id)
                ->where('reports.isDone', '=', false)
                ->count();
        @endphp
        <li class="nav-item @if($key == 0) active @endif">
            <a class="nav-link @if($key == 0) active @endif" id="tab{{ $program->id }}" data-toggle="tab" href="#content{{ $program->id }}">{{ $program->program_name }} <span class="badge badge-success">{{ $count }}</span></a>
        </li>
    @endforeach
</ul>


<div class="tab-content">
    @foreach ($programs as $key => $program)
    <div id="content{{ $program->id }}" class="tab-pane fade show @if($key == 0) active @endif">
        @php
            $reports = DB::table('reports')
                ->join('users', 'reports.user_id', '=', 'users.id')
                ->where('users.program_id', '=', $program->id)
                ->where('reports.isDone', '=', false)
                ->select('reports.*')
                ->orderBy('reports.created_at', 'asc')
                ->get();
        @endphp
        <div class="text-center" style="padding: 25px;">
            <div class="card-columns">
                @foreach ($report_categories as $report_category)
                @php
                    $report_count = 0;
                    foreach ($reports as $report) {
                        if($report->category_id == $report_category->id){
                            $report_count++;
                        }
                    }
                @endphp
    
                <div class="card text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $report_category->category_name }}</h5>
                        <p class="card-text">{{ $report_count }} reports</p>
                        <a href="{{ route('dashboard.view', ['category_name' => $report_category->category_name, 'program_id' => $program->id, 'report_category' => $report_category->id]) }}" class="btn btn-primary">view</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection