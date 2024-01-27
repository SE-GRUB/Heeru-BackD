@extends('backend.layout')

@section('title', 'Program')

@section('content')

<div>
    @if(session()->has('success'))
    <div>
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('program.create') }}" class="btn btn-primary">Add New User</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Program Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($programs as $program)
            <tr>
                <td>{{ $program->id }}</td>
                <td>{{ $program->program_name }}</td>
                <td>{{ $program->start_date }}</td>
                <td>{{ $program->end_date }}</td>
                <td>
                    <a href="{{ route('program.edit', ['program' => $program]) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ route('program.destroy', ['program' => $program]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this program?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection