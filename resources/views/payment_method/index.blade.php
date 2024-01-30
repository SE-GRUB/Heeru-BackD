@extends('backend.layout')

@section('title', 'Payment Methods')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('payment_method.create') }}" class="btn btn-primary">Add New Payment Method</a>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Payment Method Name</th>
            <th>Service Charge</th>
            <th>Active</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payment_methods as $payment_method)
            <tr>
                <td>{{ $payment_method->id }}</td>
                <td>{{ $payment_method->payment_method_name }}</td>
                <td>{{ 'Rp ' . number_format($payment_method->service_charge, 0, ',', '.') }}</td>
                <td>{{ $payment_method->isActive ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('payment_method.edit', ['payment_method' => $payment_method]) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ route('payment_method.destroy', ['payment_method' => $payment_method]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this payment method?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection