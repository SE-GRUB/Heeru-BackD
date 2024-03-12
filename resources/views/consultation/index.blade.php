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
            <th>Rating</th>
            <th>Review</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($consultations as $consultation)
        @php
            $rating = App\Models\Rating::where('consultation_id', $consultation->id)->first();
        @endphp
            <tr>
                <td>{{ $consultation->id }}</td>
                <td>{{ $consultation->student_id }}</td>
                <td>{{ $consultation->counselor_id }}</td>
                <td>{{ $consultation->consultation_date }}</td>
                <td>{{ $consultation->duration }}</td>
                <td>{{ $consultation->note }}</td>
                <td>
                    {{-- <a href="{{ route('rating.index', ['consultation' => $consultation]) }}" class="btn btn-primary">View Rating</a> --}}
                    @if($rating)
                        {{ $rating->rating }}
                    @else
                        0 {{-- Display 0 if $rating does not exist --}}
                    @endif
                </td>
                <td>
                    @if($rating)
                        {{ $rating->review }}
                    @else
                        Not Rated Yet {{-- Display 'Not Rated Yet' if $rating does not exist --}}
                    @endif
                </td>
                <td>
                    <form method="post" action="{{ route('consultation.destroy', ['consultation' => $consultation]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this consultation?')">Delete</button>
                    </form>
                    <a href="{{ route('consultation_result.index',  ['consultation' => $consultation])}}" class="btn btn-primary">View Note</a>
                    @if(!$consultation->isPaid)
                        <a href="{{ route('payment.create',  ['consultation' => $consultation])}}" class="btn btn-success">Pay</a>
                    @endif
                    @if(!$rating)
                        <a href="{{ route('rating.create', ['consultation' => $consultation]) }}" class="btn btn-outline-primary">Rate</a>
                    @else
                        <form method="post" action="{{ route('rating.destroy', ['rating' => $rating, 'consultation' => $consultation]) }}" style="display: inline-block;">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this rating?')">Delete Rating</button>
                        </form>
                    @endif
                </td>

            </tr>
        @endforeach
    </tbody>
</table>

@endsection