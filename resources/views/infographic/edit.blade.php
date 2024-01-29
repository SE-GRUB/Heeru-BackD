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
        <td>
            @php
                $img=DB::table('infographic_images')->where('info_id', $infographic->id)->get();
            @endphp
                {{-- @dd($img) --}}
                @foreach($img as $image)
                    <img src="{{ url($image->image_path) }}" alt="" style="width: 100px; height: 100px; object-fit: cover;" id="imgpoin{{$image->id}}" onclick="hapusgambar({{$image->id}})">
                @endforeach
        </td>

        <script>
            function hapusgambar(params) {
                console.log(params);
                // fetch to localhost:8000/api/deleteimage
                var url="{{ url('/infographic/iddel') }}?id="+params;
                // alert(url);
                fetch(url)
                .then(response => response.json())
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        </script>
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
