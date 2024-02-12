@extends('backend.layout')

@section('title', 'Add Report')
@section('icon', 'file-graph')

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
        <form action="{{ route('report.store') }}" method="post">
            @csrf
            @method("post")

            <div class="form-group">
                <label for="user_id">User :</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="title">Evidence:</label>
                <input type="text" class="form-control" id="evidence" name="evidence" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($report_categories as $report_categorie)
                        <option value="{{ $report_categorie->id }}">{{ $report_categorie->category_name }}</option>
                    @endforeach
                </select>
            </div>

            <h5><b>Complete these question naires to provide more information about the issue you are reporting.</b></h5><br>

            <div class="form-group">
                <label for="w1">What is the incident?</label><br>
                <i>Apa yang terjadi ?</i>
                <textarea class="form-control" id="w1" name="w1" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="w2">Why did the incident happen?</label><br>
                <i>Mengapa peristiwa ini terjadi ?</i>
                <textarea class="form-control" id="w2" name="w2" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="w3">Where did the incident happen?</label><br>
                <i>Dimana lokasi peristiwa itu terjadi ?</i>
                <textarea class="form-control" id="w3" name="w3" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="w4">When did the incident happen?</label><br>
                <i>Kapan peristiwa ini terjadi ?</i>
                <textarea class="form-control" id="w4" name="w4" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="w5">Who is/are involved in the incident?</label><br>
                <i>Siapa yang terlibat dalam peristiwa ini ?</i>
                <textarea class="form-control" id="w5" name="w5" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="h1">How did the incident happen?</label><br>
                <i>Bagaimana kejadian ini terjadi ?</i>
                <textarea class="form-control" id="h1" name="h1" rows="3" required></textarea>
            </div>
            
        
            <button type="submit" class="btn btn-primary">Add Report</button>
        </form>
    </div>

@endsection