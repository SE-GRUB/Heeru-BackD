@extends('backend.layout')

@section('title', 'Edit Status')

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
        <form action="{{ route('status.update', ['status' => $status]) }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("put")

            <div class="form-group">
                <label for="report_id">Report :</label>
                <select class="form-control" id="report_id" name="report_id" required>
                    @foreach($reports as $report)
                        <option value="{{ $report->id }}" {{ $status->report_id == $report->id ? 'selected' : '' }}>
                            {{ $report->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <input type="hidden" name="user_id" value="{{ $report->user_id }}">
            
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="sent" {{ $status->status == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="on_progress" {{ $status->status == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="done" {{ $status->status == 'done' ? 'selected' : '' }}>Done</option>
                </select>
            </div>            

            <div class="form-group">
                <label for="note">Note:</label>
                <input type="text" class="form-control" id="note" name="note" value="{{ $status->note }}" required>
            </div>
            

            <button type="submit" class="btn btn-primary">Edit User</button>
        </form>
    </div>

@endsection