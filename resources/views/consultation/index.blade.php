@extends('backend.layout')

@section('title', 'Consultation')
@section('icon', 'heart')

@section('button')
    <a href="{{ route('consultation.create') }}" class="btn btn-primary">Add New Consultation</a>
@endsection

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Counselor ID</th>
            <th>Consultation Date</th>
            <th>Duration</th>
            <th>Note</th>
            <th>Action</th>
            <th>Rating</th>

        </tr>
    </thead>
    <tbody>
        @foreach($consultation as $consultation)
            <tr>
                <td>{{ $consultation->id }}</td>
                <td>{{ $consultation->student_id }}</td>
                <td>{{ $consultation->counselor_id }}</td>
                <td>{{ $consultation->consultation_date }}</td>
                <td>{{ $consultation->duration }}</td>
                <td>{{ $consultation->note }}</td>


                <td>
                    {{-- <a href="{{ route('consultation.edit', ['consultations' => $consultations]) }}" class="btn btn-primary">Edit</a> --}}
                    <form method="post" action="{{ route('consultation.destroy', ['consultation' => $consultation]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this consultation?')">Delete</button>
                    </form>
                    <a href="{{ route('consultation_result.index',  ['consultation' => $consultation])}}" class="btn btn-primary">View Note</a>
                    @if(!$consultation->isPaid)
                        <a href="{{ route('payment.create',  ['consultation' => $consultation])}}" class="btn btn-primary">Pay</a>
                    @endif
                </td>

                <td>
                    <a href="{{ route('rating.index', ['consultation' => $consultation]) }}" class="btn btn-primary">View Rating</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection