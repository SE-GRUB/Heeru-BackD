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
<a href="{{ route('reportCategories.create') }}" class="btn btn-primary">Add New Report Categories</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
        
        </tr>
    </thead>
    <tbody>
        <!-- Loop through your users data and populate the table rows -->
        @foreach($report_category as $reportCategories)
            <tr>
                <td>{{ $reportCategories->id}}</td>
                <td>{{ $reportCategories->category_name}}</td>
        
                <td>
                    <a href="{{ route('reportCategories.edit', ['reportCategories' => $reportCategories]) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ route('reportCategories.destroy', ['report_category' => $reportCategories]) }}" style="display: inline-block;">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection