@extends('backend.layout')

@section('title', 'Report Categories')
@section('icon', 'folder')

@section('button')
    <a href="{{ route('report_category.create') }}" class="btn btn-primary">Add New Report Category</a>
@endsection

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Weight</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through your users data and populate the table rows -->
        @foreach($report_categories as $report_category)
            <tr>
                <td>{{ $report_category->id}}</td>
                <td>{{ $report_category->category_name}}</td>
                <td>{{ $report_category->weight}}</td>

        
                <td>
                    <a href="{{ route('report_category.edit', ['report_category' => $report_category]) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ route('report_category.destroy', ['report_category' => $report_category]) }}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection