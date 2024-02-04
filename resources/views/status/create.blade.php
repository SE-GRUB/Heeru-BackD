@extends('backend.layout')

@section('title', 'Add User')

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
        <form action="{{ route('status.store') }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")

            <div class="form-group">
                <label for="report_id">Report :</label>
                <select class="form-control" id="report_id" name="report_id" required>
                    @foreach($reports as $report)
                        <option value="{{ $report->id }}">{{ $report->title }}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="sent" selected>Sent</option>
                    <option value="on_progress">On Progress</option>
                    <option value="done">Done</option>
                </select>
            </div>

            <div class="form-group">
                <label for="note">Note:</label>
                <input type="text" class="form-control" id="note" name="note" required>
            </div>
            

            <button type="submit" class="btn btn-primary">Edit User</button>
        </form>
    </div>

@endsection