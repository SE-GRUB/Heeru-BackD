@extends('backend.layout')

@section('title', 'Report')
@section('icon', 'file-graph')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('report.create',  ['report_categories' => $report_categories]) }}" class="btn btn-primary">Add New report</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Title</th>
            <th>Time</th>
            <th>Evidence</th>
            <th>Category</th>
            <th>Category name</th>
            <th>IsProcess</th>
            <th>IsDone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through your users data and populate the table rows -->
        @foreach($reports as $report)
            <tr>
                <td>{{ $report->id}}</td>
                @php
                    $name = DB::table('users')->where('id', $report->user_id)->value('name')
                @endphp
                <td>{{ $name }}</td>
                <td>{{ $report->title}}</td>
                <td>{{ $report->created_at}}</td>
                <td>{{ $report->evidence }}</td>
                <td>{{ $report->category_id }}</td>
                

                @php
                    $category_name = DB::table('report_categories')->where('id', $report->category_id)->value('category_name')
                @endphp
                
                <td>{{ $category_name }}</td>

                <td>{{ $report->IsProcess ? 'Yes' : 'No' }}</td>
                <td>{{ $report->isDone ? 'Yes' : 'No' }}</td>

                <td>
                    <a href="{{ route('report.edit', ['report' => $report]) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('dashboard.detail', ['report' => $report]) }}" class="btn btn-info">View Details</a>
                    <form method="post" action="{{ route('report.destroy', ['report' => $report]) }}" style="display: inline-block;">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection