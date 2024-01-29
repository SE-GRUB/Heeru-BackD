@extends('backend.layout')

@section('title', 'Edit Report')

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
        <form action="{{route('report.update', ['report'=>$report])}}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method('put')

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $report->title }}" required>
            </div>

            <div class="form-group">
                <label for="title">Evidence:</label>
                <input type="text" class="form-control" id="evidence" name="evidence" value="{{ $report->evidence }}"required>
            </div>


            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control" id="category_id" name="category_id" selected="{{ $report->category_id }}" required>
                    @foreach($report_categories as $report_categorie)
                        <option value="{{ $report_categorie->id }}">{{ $report_categorie->category_name  }}</option>
                    @endforeach
                </select>
            </div>
            


        
            <button type="submit" class="btn btn-primary">Edit Report</button>
        </form>
    </div>

@endsection