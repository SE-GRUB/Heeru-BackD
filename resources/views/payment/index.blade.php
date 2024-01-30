@extends('backend.layout')

@section('title', 'Payments')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
{{-- <a href="{{ route('payment.create') }}" class="btn btn-primary">Add New Payment</a> --}}
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Consultation ID</th>
            <th>Payment Method</th>
            {{-- <th>Service Charge</th>
            <th>Active</th> --}}
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->consultation_id }}</td>
                @php
                    $payment_method_name = DB::table('payment_methods')
                            ->where('payment_methods.id',  $payment->payment_method_id)
                            ->value('payment_method_name');
                @endphp
                <td>{{ $payment_method_name ?? 'N/A' }}</td>
                {{-- <td>{{ 'Rp ' . number_format($payment->paymentMethod->service_charge ?? 0, 0, ',', '.') }}</td>
                <td>{{ $payment->paymentMethod->isActive ? 'Yes' : 'No' }}</td> --}}
                <td>
                    {{-- <a href="{{ route('payment.edit', ['payment' => $payment]) }}" class="btn btn-primary">Edit</a> --}}
                    <form method="post" action="{{ route('payment.destroy', ['payment' => $payment]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this payment?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection