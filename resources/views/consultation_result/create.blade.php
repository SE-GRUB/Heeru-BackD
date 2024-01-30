@extends('backend.layout')

@section('title', 'Add Comment')

@section('content')
    <div class="container mt-5">
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('consultation_result.store', ['consultations' => $consultations]) }}" method="post" enctype="multipart/form-data">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")
            <input type="hidden" name="counselor_id" value="{{ $consultations->counselor_id }}">
            <input type="hidden" name="student_id" value="{{ $consultations->student_id }}">
            <input type="hidden" name="id" value="{{ $consultations->id }}">

            <div class="form-group">
                <label for="note">Result :</label>
                <input type="text" class="form-control" id="note" name="note" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Result</button>
        </form>
    </div>
@endsection