@extends('backend.layout')

@section('title', 'Comment Replies')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('consultation_result.create', ['consultation' => $consultation]) }}" class="btn btn-primary">Add Result</a>
<h3>Post :</h3>
<div>{{ $consultation->id }}</div>
{{-- <h1>{{ $consultation->comment }}</h1> --}}
<h3>Note:</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Consultation ID</th>
            <th>Result</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($consultation_result as $consultation_result)
            <tr>
                <td>{{ $consultation_result->id }}</td>
                <td>{{ $consultation_result->consultation_id }}</td>
                <td>{{ $consultation_result->note }}</td>
                

                <td>
                    <form method="post" action="{{ route('consultation_result.destroy', ['consultation_result' => $consultation_result, 'consultation' => $consultation]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this result?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection