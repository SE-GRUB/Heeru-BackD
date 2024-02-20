@extends('backend.layout')

@section('title', 'Add Rating')

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
        <form action="{{ route('rating.store', ['consultation' => $consultation]) }}" method="post" enctype="multipart/form-data">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")
            <input type="hidden" name="consultation_id" value="{{ $consultation->id }}">
            <input type="hidden" name="student_id" value="{{ $consultation->student_id }}">
            <input type="hidden" name="counselor_id" value="{{ $consultation->counselor_id }}">

            <div class="form-group">
                <label for="rating">Rating :</label>
                <input type="number" class="form-control" id="rating" name="rating" required>
            </div>

            <div class="form-group">
                <label for="review">Review:</label>
                <input type="text" class="form-control" id="review" name="review" required>
            </div>

            <button type="submit" class="btn btn-primary">Add rating</button>
        </form>
    </div>
@endsection