@extends('backend.layout')

@section('title', 'Profile')
@section('icon', 'user')

@section('content')
    <style>
        .user-card-full {
            overflow: hidden;
        }

        .card {
            border-radius: 5px;
            border: none;
            margin-bottom: 30px;
        }
        .m-r-0 {
            margin-right: 0px;
        }

        .m-l-0 {
            margin-left: 0px;
        }

        .user-card-full .user-profile {
            border-radius: 5px 0 0 5px;
        }

        .user-profile {
            padding: 20px 0;
        }

        .card-block {
            padding: 1.25rem;
        }

        .m-b-25 {
            margin-bottom: 25px;
        }

        .img-radius {
            border-radius: 5px;
        }

        h6 {
            font-size: 14px;
        }

        .card .card-block p {
            line-height: 25px;
        }

        @media only screen and (min-width: 1400px){
            p {
                font-size: 14px;
            }
        }

        .card-block {
            padding: 1.25rem;
        }

        .b-b-default {
            border-bottom: 1px solid #e0e0e0;
        }

        .m-b-20 {
            margin-bottom: 20px;
        }

        .p-b-5 {
            padding-bottom: 5px !important;
        }

        .card .card-block p {
            line-height: 25px;
        }

        .m-b-10 {
            margin-bottom: 10px;
        }

        .text-muted {
            color: #919aa3 !important;
        }

        .b-b-default {
            border-bottom: 1px solid #e0e0e0;
        }

        .text-muted {
            color: #919aa3 !important;
        }

        .f-w-600 {
            font-weight: 600;
        }

        .photoprofile {
            display: flex;
            justify-content: center;
            text-align: center;
        }

        .m-b-20 {
            margin-bottom: 20px;
        }

        .m-t-40 {
            margin-top: 20px;
        }

        .p-b-5 {
            padding-bottom: 5px !important;
        }

        .m-b-10 {
            margin-bottom: 10px;
        }

        .m-t-40 {
            margin-top: 20px;
        }

        .user-card-full .button-link {
            display: inline-block;
        }

        .user-card-full .button-link button {
            font-size: 14px;
            margin: 0 10px 0 0;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .lingkarannya {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #profileImages {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 767px) {
            .lingkarannya {
                width: 80px;
                height: 80px;
            }
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
    </style>
    <div>
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
    </div>
    <div class="card user-card-full">
        <div class="row m-0">
            <div class="col-lg-4 user-profile">
                <div class="card-block text-center text-white">
                    <div class="m-b-25">
                        <form id="update_profile_pic_form" action="{{ route('update.pp') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="photoprofile">
                                <div class="lingkarannya">
                                    <label for="upload_profile_pic" class="edit-icon" id="labelForFileInput">
                                        <img id="profileImages" src="{{ $user['profile_pic'] ? asset($user['profile_pic']) : asset('Admin/images/profile.jpg') }}" alt="User-Profile-Image">
                                        <input type="file" id="upload_profile_pic" name="profile_pic" style="display: none;">
                                    </label>
                                </div>
                            </div>
                            <div class="button-container">
                                <button type="submit" id="update_photo_btn" form="update_profile_pic_form" class="btn btn-primary" style="display: none;">Update Photo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card-block">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="m-b-10 f-w-600">Name</p>
                            <h6 class="text-muted f-w-400">{{ $user['name'] }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="m-b-10 f-w-600">Role</p>
                            <h6 class="text-muted f-w-400">{{ $user['role'] }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="m-b-10 f-w-600">Email</p>
                            <h6 class="text-muted f-w-400">{{ $user['email'] }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="m-b-10 f-w-600">Phone</p>
                            <h6 class="text-muted f-w-400">{{ $user['no_telp'] }}</h6>
                        </div>
                    </div>
                    <div class="button-link list-unstyled m-t-40 m-b-10">
                        <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
                    <div/>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
                document.getElementById('upload_profile_pic').addEventListener('change', function (event) {
                const fileInput = event.target;
                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        document.getElementById("profileImages").src = e.target.result;
                        document.getElementById("update_photo_btn").style.display = "block";
                        // document.getElementById("profileImage").style.display = "block";
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            });
        });
    </script>
    @endpush
    <!-- Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form id="changePasswordForm" action="{{ route('change.password') }}" method="POST">
            @csrf
            @method( 'put' )
            <div class="modal-body">
                <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submitCP" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('submitCP').addEventListener('submit', function(event) {
            event.preventDefault();
            var nip = document.getElementById("phone_nip");
            var no_telp = document.getElementById("phone_number");
            var new_password = document.getElementById("new_password");

            var errortext1 = document.getElementById("errortext1");
            var errortext2 = document.getElementById("errortext2");
            var errortext3 = document.getElementById("errortext3");

            if(nip.value.trim() === ""){
                errortext1.innerHTML = "NIP cannot be empty";
                errortext1.classList.remove("hide");
            } else {
                errortext1.classList.add("hide");
            }

            if(no_telp.value.trim() === ""){
                errortext2.innerHTML = "Phone number cannot be empty";
                errortext2.classList.remove("hide");
            } else {
                errortext2.classList.add("hide");
                if (validatePhoneNumber(no_telp.value)) {
                    if (no_telp.value.startsWith('+62')) {
                        no_telp.value = '0' + no_telp.value.substring(3);
                    }
                    errortext2.classList.add("hide");
                } else {
                    errortext2.innerHTML  = "Phone number is not valid";
                    errortext2.classList.remove("hide");
                }
            }

            if(new_password.value.trim() === ""){
                errortext3.innerHTML = "Password cannot be empty";
                errortext3.classList.remove("hide");
            } else {
                errortext3.classList.add("hide");
                if(!/[A-Z]/.test(new_password.value)){
                    errortext3.innerText = "Your password must contain at least one uppercase letter";
                    errortext3.classList.remove("hide");
                } else {
                    if (new_password.value.length < 8 ) {
                        errortext3.innerHTML = "Password must be at least 8 characters long";
                        errortext3.classList.remove("hide");
                    } else {
                        if(!/[a-z]/.test(new_password.value)){
                            errortext3.innerText = "Your password must contain at least one lowercase letter";
                            errortext3.classList.remove("hide");
                        } else {
                            if(!/\d/.test(new_password.value)){
                                errortext3.innerText = "Your password must contain at least one number.";
                                errortext3.classList.remove("hide");
                            } else {
                                errortext3.classList.add('hide');
                                document.getElementById('phoneForm').submit();
                                return true;
                            }
                        }
                    }
                }
            }
            return false;
        });
        </script>
    @endpush
@endsection