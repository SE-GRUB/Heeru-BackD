@extends('backend.layout')

@section('title', $category_name)
@section('icon', 'tachometer-fast')

@section('useDatatables', false)

@section('content')
<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('dashboard_report.index') }}" class="btn btn-primary">Back</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Report's Author</th>
            <th>Title</th>
            <th>Time</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
            <tr>
                <td>{{ $report->id }}</td>
                @php
                    $username = DB::table('users')->where('users.id', $report->user_id)->value('name');
                @endphp
                <td>{{ $username }}</td>
                <td>{{ $report->title }}</td>
                <td>{{ $report->created_at }}</td>
                <td>
                    <a href="{{ route('dashboard_report.detail', ['report' => $report->id]) }}" class="btn btn-primary">View Details</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection