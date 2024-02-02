@extends('backend.layout')

@section('title', 'Report')

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
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through your users data and populate the table rows -->
        @foreach($reports as $report)
            <tr>
                <td>{{ $report->id}}</td>
                <td>
                    @php
                        $name = DB::table('users')->where('id', $report->user_id)->value('name')
                    @endphp
                    {{ $name }}
                </td>
                <td>{{ $report->title}}</td>
                <td>{{ $report->created_at}}</td>
                <td>{{ $report->evidence }}</td>
                

                @php
                    $category_name = DB::table('report_categories')->where('id', $report->category_id)->value('category_name')
                @endphp
                
                <td>{{ $category_name }}</td>

                <td>
                    <a href="{{ route('report.edit', ['report' => $report]) }}" class="btn btn-primary">Edit</a>
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