@extends('backend.layout')

@section('title', 'Add User')
@section('icon', 'user')

@section('content')
<style>
    .container-fluid{
        justify-content: center;
        text-align: center;
    }

    .photoprofile{
        display: flex;
        justify-content: center;
        text-align: center;
    }
    
    .lingkarannya{
        background-color: #D6D6D6;
        width: 100px;
        height: 100px;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    #labelForFileInput{
        width: 100%;
        height: 100%;
        border-radius: 50%; 
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #profileImage {
        width: 100%;
        height: 100%;
        border-radius: 50%; 
        object-fit: cover;
    }
</style>

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
        <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")


            <div id="photoFields">
                <div class="container-fluid">
                    <div class="photoprofile">
                        <div class="lingkarannya" id="profileImageContainer">
                            <label for="profile_pic" class="edit-icon" id="labelForFileInput">
                                {{-- <label class="edit-icon"> --}}
                                <img id="pensil" src="{{ asset("asset/editpp.png") }}" alt="" />
                                {{-- </label> --}}
                                <img style="display: none;" id="profileImage" src="" alt="" />
                                <input type="file" id="profile_pic" name="profile_pic" accept="image/*" style="display: none;"/>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="student" selected>Student</option>
                    <option value="pic">PIC</option>
                    <option value="counselor">Counselor</option>
                    <option value="admin">Admin</option>

                </select>
            </div>
            
            <div id="studentFields">
                <div class="form-group">
                    <label for="program_id">Program:</label>
                    <select class="form-control" id="program_id" name="program_id">
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->program_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Additional Fields for PIC -->

            <div id="picFields">
                <div class="form-group">
                    <label for="nip">NIP:</label>
                    <input type="number" class="form-control" id="nip" name="nip">
                </div>

                

            </div>

            <!-- Additional Fields for Counselor -->
            <div id="counselorFields" style="display:none">
                <div class="form-group">
                    <label for="fare">Fare:</label>
                    <input type="number" class="form-control" id="fare" name="fare">
                </div>
            </div>

             <!-- Additional Fields for Admin -->
             <div id="adminFields">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

               
            </div>

            <div class="form-group">
                <label for="no_telp">Phone Number:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>

            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>
@endsection
