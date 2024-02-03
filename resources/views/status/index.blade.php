@extends('backend.layout')

@section('title', 'Report Status')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
{{-- Statusnya jangan dicreate  --}}
{{-- <a href="{{ route('status.create') }}" class="btn btn-primary">Add Status</a> --}}
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Report</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through your users data and populate the table rows -->
        @foreach($status as $status)
            <tr>
                <td>{{ $status->id}}</td>
                @php
                    $report_title = DB::table('reports')->where('id', $status->report_id)->value('title')
                @endphp
                
                <td>{{ $report_title }}</td>
                <td>{{ $status->status}}</td>

        
                <td>
                    <a href="{{ route('status.edit', ['status' => $status]) }}" class="btn btn-primary">Edit Status</a>
                    <form method="post" action="{{ route('status.destroy', ['status' => $status]) }}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this status?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection