@extends('backend.layout')

@section('title', 'Edit Infographic')

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
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($infographic_images as $infographic_image)
                    <tr>
                        <td>{{ $infographic_image->id}}</td>

                        <td>
                                    <img src="{{ url($infographic_image->image_path) }}" alt="" style="width: 600px; object-fit: cover;">
                        </td>
                        <td>
                            <form method="post" action="{{ route('infographic_image.destroy', ['infographic_image' => $infographic_image]) }}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this infographic?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('infographic.update', ['infographic'=>$infographic])}}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("put")

            <div class="form-group">
                <label for="title">Infographic Title:</label>
                <input type="text" class="form-control" id="title" name="title"  value="{{ $infographic->title }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Edit Infographic</button>
        </form>
    </div>
@endsection