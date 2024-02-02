@extends('backend.layout')

@section('title', $category_name)

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('dashboard.index') }}" class="btn btn-primary">Back</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Report's Author</th>
            <th>Title</th>
            <th>Time</th>
            <th>Evidence</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through your users data and populate the table rows -->
        @foreach($reports as $report)
            <tr>
                <td>{{ $report->id }}</td>
                @php
                    $username = DB::table('users')->where('users.id', $report->user_id)->value('name');
                @endphp
                <td>{{ $username }}</td>
                <td>{{ $report->title }}</td>
                <td>{{ $report->created_at }}</td>
                <td>{{ $report->evidence }}</td>
                <td>
                    <a href="{{ route('report.edit', ['report' => $report->id]) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ route('report.destroy', ['report' => $report->id]) }}" style="display: inline-block;">
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