@extends('backend.layout')

@section('title', 'Add Rating')
@section('title', 'Rating')
@section('icon', 'star')

@section('content')
<style>
    .container{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .rating {
        display: inline-block;
        position: relative;
        height: 50px;
        line-height: 50px;
        font-size: 50px;
    }

    .rating label {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        cursor: pointer;
    }

    .rating label:last-child {
        position: static;
    }

    .rating label:nth-child(1) {
        z-index: 5;
    }

    .rating label:nth-child(2) {
        z-index: 4;
    }

    .rating label:nth-child(3) {
        z-index: 3;
    }

    .rating label:nth-child(4) {
        z-index: 2;
    }

    .rating label:nth-child(5) {
        z-index: 1;
    }

    .rating label input {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
    }

    .rating label .icon {
        float: left;
        color: transparent;
    }

    .rating label:last-child .icon {
        color: #90A0A3;
    }

    .rating:not(:hover) label input:checked ~ .icon,
    .rating:hover label:hover input ~ .icon {
        color: #F79426;
    }

    .rating label input:focus:not(:checked) ~ .icon:last-child {
        color: #FECE31;
        text-shadow: 0 0 5px #09f;
    }
</style>
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
    <form id="ratingForm" action="{{ route('rating.store', ['consultation' => $consultation]) }}" method="post" enctype="multipart/form-data">
        <!-- CSRF Token for Laravel -->
        @csrf
        @method("post")
        <input type="hidden" name="consultation_id" value="{{ $consultation->id }}">
        <input type="hidden" name="student_id" value="{{ $consultation->student_id }}">
        <input type="hidden" name="counselor_id" value="{{ $consultation->counselor_id }}">

        <div class="rating">
            <label>
                <input type="radio" name="stars" value="1" />
                <span class="icon">★</span>
            </label>
            <label>
                <input type="radio" name="stars" value="2" />
                <span class="icon">★</span>
                <span class="icon">★</span>
            </label>
            <label>
                <input type="radio" name="stars" value="3" />
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>   
            </label>
            <label>
                <input type="radio" name="stars" value="4" />
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
            </label>
            <label>
                <input type="radio" name="stars" value="5" />
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
            </label>
        </div>
        
        <div class="form-group">
            <label for="review">Review:</label>
            <textarea type="text" class="form-control" id="review" name="review" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Add rating</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('ratingForm').addEventListener('submit', function(event) {
        const selectedStars = document.querySelector('input[name="stars"]:checked');
        if (!selectedStars) {
            alert('Please select a rating!');
            event.preventDefault();
        }
    });
</script>
@endpush