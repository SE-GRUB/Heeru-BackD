@extends('backend.layout')

@section('title', 'Edit Report')
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
            
            <h5><b>Complete these question naires to provide more information about the issue you are reporting.</b></h5><br>
            @php
                $data = json_decode($report->details);
            @endphp

            <div class="form-group">
                <label for="w1">What is the incident?</label><br>
                <i>Apa yang terjadi ?</i>
                <textarea class="form-control" id="w1" name="w1" rows="3" required>{{ isset($data->w1) ? $data->w1 : '' }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="w2">Why did the incident happen?</label><br>
                <i>Mengapa peristiwa ini terjadi ?</i>
                <textarea class="form-control" id="w2" name="w2" rows="3" required>{{ isset($data->w2) ? $data->w2 : '' }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="w3">Where did the incident happen?</label><br>
                <i>Dimana lokasi peristiwa itu terjadi ?</i>
                <textarea class="form-control" id="w3" name="w3" rows="3" required>{{ isset($data->w3) ? $data->w3 : '' }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="w4">When did the incident happen?</label><br>
                <i>Kapan peristiwa ini terjadi ?</i>
                <textarea class="form-control" id="w4" name="w4" rows="3" required>{{ isset($data->w4) ? $data->w4 : '' }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="w5">Who is/are involved in the incident?</label><br>
                <i>Siapa yang terlibat dalam peristiwa ini ?</i>
                <textarea class="form-control" id="w5" name="w5" rows="3" required>{{ isset($data->w5) ? $data->w5 : '' }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="h1">How did the incident happen?</label><br>
                <i>Bagaimana kejadian ini terjadi ?</i>
                <textarea class="form-control" id="h1" name="h1" rows="3" required>{{ isset($data->h1) ? $data->h1 : '' }}</textarea>
            </div>

        
            <button type="submit" class="btn btn-primary">Edit Report</button>
        </form>
    </div>

@endsection