@extends('backend.layout')

@section('title', 'Rating')
@section('icon', 'star')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('rating.create', ['consultation' => $consultation]) }}" class="btn btn-primary">Add New Rating</a>
<h3>Consultation :</h3>
<div>{{ $consultation->id }}</div>
<h3>Rating:</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Counselor ID</th>
            <th>Student ID</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ratings as $rating)
            <tr>
                <td>{{ $rating->id }}</td>
                <td>{{ $rating->student_id }}</td>
                <td>{{ $rating->counselor_id }}</td>
                <td>{{ $rating->rating }}</td>
                <td>{{ $rating->review }}</td>

                <td>
                    <form method="post" action="{{ route('rating.destroy', ['rating' => $rating, 'consultation' => $consultation]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this rating?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection