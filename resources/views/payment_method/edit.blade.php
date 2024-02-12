@extends('backend.layout')

@section('title', 'Edit Payment Method')
@section('icon', 'credit-card-search')

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
        <form action="{{ route('payment_method.update', ['payment_method' => $payment_method]) }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("put")

            <div class="form-group">
                <label for="payment_method_name">Payment Method Name:</label>
                <input type="text" class="form-control" id="payment_method_name" name="payment_method_name" value="{{ $payment_method->payment_method_name }}" required>
            </div>

            <div class="form-group">
                <label for="service_charge">Service Charge:</label>
                <input type="number" class="form-control" id="service_charge" name="service_charge" value="{{ $payment_method->service_charge }}" required>
            </div>

            <div class="form-group">
                <label for="isActive">Active:</label>
                <select class="form-control" id="isActive" name="isActive" Selected="{{ $payment_method->isActive }}" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Payment Method</button>
        </form>
    </div>
@endsection
