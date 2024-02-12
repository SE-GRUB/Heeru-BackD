@extends('backend.layout')

@section('title', 'Add Payment')
@section('icon', 'bill')

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
        <form action="{{ route('payment.store', ['consultation' => $consultation]) }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")

            <input type="hidden" id="consultation_id" name="consultation_id" value="{{ $consultation->id }}" required>

            @php
                $fare = DB::table('users')
                ->where('users.id', $consultation->counselor_id)
                ->value('fare');
                $total = $consultation->duration * $fare
                @endphp
            <label for="price">Details: :</label>
            <h3>Rp {{ number_format($fare, 0, ',', '.') }} * {{$consultation->duration}} hour</h3>
            <label for="price">Total :</label>
            <h1>Rp {{ number_format($total, 0, ',', '.') }}</h1>

            <div class="form-group">
                <label for="payment_method_id">Payment Method:</label>
                <select class="form-control" id="payment_method_id" name="payment_method_id" required>
                    @foreach($payment_methods as $payment_method)
                        <option value="{{ $payment_method->id }}">{{ $payment_method->payment_method_name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Payment</button>
        </form>
    </div>
@endsection
