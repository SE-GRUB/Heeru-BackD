@extends('backend.layout')

@section('title', 'Add Payment Method')

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
        <form action="{{ route('payment_method.store') }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")

            <div class="form-group">
                <label for="payment_method_name">Payment Method Name:</label>
                <input type="text" class="form-control" id="payment_method_name" name="payment_method_name" required>
            </div>

            <div class="form-group">
                <label for="service_charge">Service Charge:</label>
                <input type="number" class="form-control" id="service_charge" name="service_charge" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Payment Method</button>
        </form>
    </div>
@endsection
