@extends('backend.layout')

@section('title', 'Edit Result')

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
        <form action="{{ route('consultation_result.update', ['consultation_result' => $consultation_result, 'consultation' => $consultation]) }}" method="post" enctype="multipart/form-data">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("put")
            {{-- <input type="hidden" name="counselor_id" value="{{ $consultation->counselor_id }}">
            <input type="hidden" name="student_id" value="{{ $consultation->student_id }}">
            <input type="hidden" name="consultation_id" value="{{ $consultation->id }}"> --}}

            <div class="form-group">
                <label for="note">Result :</label>
                <input type="text" class="form-control" id="note" name="note" value="{{ $consultation_result->note }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Edit Result</button>
        </form>
    </div>
@endsection