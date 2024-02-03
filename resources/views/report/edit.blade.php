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
                <label for="user_id">User ID:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
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
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($report_categories as $report_category)
                        <option value="{{ $report_category->id }}" @if($report_category->id == $report->category_id) selected @endif>
                            {{ $report_category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>            

        
            <button type="submit" class="btn btn-primary">Edit Report</button>
        </form>
    </div>

@endsection