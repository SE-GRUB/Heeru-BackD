@extends('backend.layout')

@section('title', 'Infographic')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('infographic.create') }}" class="btn btn-primary">Add New Program</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($infographics as $infographic)
            <tr>
                <td>{{ $infographic->id}}</td>
                <td>{{ $infographic->title}}</td>

                <td>
                    @php
                        $img=DB::table('infographic_images')->where('info_id', $infographic->id)->get();
                    @endphp
                        {{-- @dd($img) --}}
                        @foreach($img as $image)
                            <img src="{{ $image->image_path }}" alt="" style="width: 100px; height: 100px; object-fit: cover;">
                        @endforeach
                </td>

                <td>
                    <a href="{{ route('infographic.edit', ['infographic' => $infographic]) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ route('infographic.destroy', ['infographic' => $infographic]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this infographic?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
