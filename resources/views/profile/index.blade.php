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
            font-size: 18px;
        }

        .card .card-block p {
            line-height: 25px;
        }

        @media only screen and (min-width: 1400px){
            p {
                font-size: 18px;
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

        .text-danger{
            color: red;
            text-align: left;
            font-size: 14px;
        }

        .hide{
            display: none;
        }

        .togglePassword {
            text-align: center;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            padding: 0 18px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        /* Tab Container Style */
        .nav-tabs {
            display: flex;
            justify-content: space-between;
            border-bottom: none; /* Remove default border */
        }

        /* Tab Link Style */
        .nav-item {
            flex: 1; /* Distribute available space equally */
        }

        .nav-link {
            text-align: center; /* Center the tab text */
            border: none; /* Remove default border */
            border-radius: 0; /* Remove default border radius */
            background-color: #fff; /* Set background color */
            color: #6c757d; /* Set text color */
            font-weight: bold; /* Optionally set font weight */
        }

        /* Active Tab Link Style */
        .nav-item .nav-link.active {
            background-color: #f8f9fa; /* Set active tab background color */
            color: #495057; /* Set active tab text color */
        }

        /* Tab Content Style */
        .tab-content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
        }

        /* Tab Content Pane Style */
        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
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
                    <div class="button-link list-unstyled m-t-40 m-b-10 d-flex justify-content-end"">
                        <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
                        <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#changeEmailPhoneModal">Change Information</button>
                    <div/>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
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
                <form id="submitCP" action="{{ route('change.password') }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="off" autofocus>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary togglePassword" id="togglePassword">
                                        <i class="fas fa-eye" id="showPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <span id="errortext1" class="text-danger hide">text</span>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="off" autofocus>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary togglePassword" id="togglePassword2">
                                        <i class="fas fa-eye" id="showPasswordIcon2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <span id="errortext2" class="text-danger hide">text</span>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off" autofocus>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary togglePassword" id="togglePassword3">
                                        <i class="fas fa-eye" id="showPasswordIcon3"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <span id="errortext3" class="text-danger hide">text</span>
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
            document.addEventListener("DOMContentLoaded", function() {
                var togglePassword = document.getElementById('togglePassword');
                var togglePassword2 = document.getElementById('togglePassword2');
                var togglePassword3 = document.getElementById('togglePassword3');
                var current_password = document.getElementById('current_password');
                var new_password = document.getElementById('new_password');
                var confirm_password = document.getElementById('confirm_password');
                var showPasswordIcon = document.getElementById("showPasswordIcon");
                var showPasswordIcon2 = document.getElementById("showPasswordIcon2");
                var showPasswordIcon3 = document.getElementById("showPasswordIcon3");
                togglePassword.addEventListener('click', function() {
                    var type = current_password.getAttribute('type') === 'password' ? 'text' : 'password';
                    current_password.setAttribute('type', type);
    
                    if (type === 'text') {
                        showPasswordIcon.classList.remove("fa-eye");
                        showPasswordIcon.classList.add("fa-eye-slash");
                    } else {
                        showPasswordIcon.classList.remove("fa-eye-slash");
                        showPasswordIcon.classList.add("fa-eye");
                    }
                });
                togglePassword2.addEventListener('click', function() {
                    var type2 = new_password.getAttribute('type') === 'password' ? 'text' : 'password';
                    new_password.setAttribute('type', type2);
    
                    if (type2 === 'text') {
                        showPasswordIcon2.classList.remove("fa-eye");
                        showPasswordIcon2.classList.add("fa-eye-slash");
                    } else {
                        showPasswordIcon2.classList.remove("fa-eye-slash");
                        showPasswordIcon2.classList.add("fa-eye");
                    }
                });
                togglePassword3.addEventListener('click', function() {
                var type3 = confirm_password.getAttribute('type') === 'password' ? 'text' : 'password';
                confirm_password.setAttribute('type', type3);

                if (type3 === 'text') {
                    showPasswordIcon3.classList.remove("fa-eye");
                    showPasswordIcon3.classList.add("fa-eye-slash");
                } else {
                    showPasswordIcon3.classList.remove("fa-eye-slash");
                    showPasswordIcon3.classList.add("fa-eye");
                }
            });
            });
            document.getElementById('submitCP').addEventListener('submit', function(event) {
            event.preventDefault();
            var current_password = document.getElementById("current_password");
            var new_password = document.getElementById("new_password");
            var confirm_password = document.getElementById("confirm_password");

            var errortext1 = document.getElementById("errortext1");
            var errortext2 = document.getElementById("errortext2");
            var errortext3 = document.getElementById("errortext3");

            if(current_password.value.trim() === ""){
                errortext1.innerHTML = "Please enter your current password";
                errortext1.classList.remove("hide");
            } else {
                errortext1.classList.add("hide");
            }

            if(new_password.value.trim() === ""){
                errortext2.innerHTML = "Password cannot be empty";
                errortext2.classList.remove("hide");
            } else {
                if(new_password.value === current_password.value){
                    errortext2.innerHTML = "New Password should not match the Current Password";
                    errortext2.classList.remove("hide");
                }else{
                    if(!/[A-Z]/.test(new_password.value)){
                    errortext2.innerText = "Your password must contain at least one uppercase letter";
                    errortext2.classList.remove("hide");
                } else {
                    if (new_password.value.length < 8 ) {
                        errortext2.innerHTML = "Password must be at least 8 characters long";
                        errortext2.classList.remove("hide");
                    } else {
                        if(!/[a-z]/.test(new_password.value)){
                            errortext2.innerText = "Your password must contain at least one lowercase letter";
                            errortext2.classList.remove("hide");
                        } else {
                            if(!/\d/.test(new_password.value)){
                                errortext2.innerText = "Your password must contain at least one number.";
                                errortext2.classList.remove("hide");
                            } else {
                                errortext2.classList.add('hide');
                            }
                        }
                    }
                }
                }
            }

            if(confirm_password.value.trim() === ""){
                errortext3.innerHTML = "Please confirm your new password";
                errortext3.classList.remove("hide");
            } else {
                if(confirm_password.value  !== new_password.value) {
                    errortext3.innerHTML = "The passwords do not match"
                    errortext3.classList.remove("hide")
                }else{
                    errortext3.classList.add("hide");
                    document.getElementById('submitCP').submit();
                    return true;
                }
            }
            return false;
        });
        </script>
    @endpush
    {{-- modal phone email --}}
    <div class="modal fade" id="changeEmailPhoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="phone-tab" data-toggle="tab" href="#phone" role="tab" aria-controls="phone" aria-selected="true">Change Phone Number</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false">Change Email</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="phone" role="tabpanel" aria-labelledby="phone-tab">
                            <form id="changePhoneForm" action="{{ route('change.phone') }}" method="POST">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="new_phone">New Phone Number</label>
                                    <input type="number" class="form-control" id="new_phone" name="new_phone" value="{{ $user['no_telp'] }}" autocomplete="off" autofocus>
                                </div>
                                <span id="errortextPhone" class="text-danger hide">text</span>
                                {{-- <button type="submit" id="submitPhone" class="btn btn-primary">Save changes</button> --}}
                            </form>
                        </div>
                        <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                            <form id="changeEmailForm" action="{{ route('change.email') }}" method="POST">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="new_email">New Email</label>
                                    <input type="text" class="form-control" id="new_email" name="new_email" value="{{ $user['email'] }}" autocomplete="off" autofocus>
                                </div>
                                <span id="errortextEmail" class="text-danger hide">text</span>
                                {{-- <button type="submit" id="submitEmail" class="btn btn-primary">Save changes</button> --}}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitCPE" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>    
    @push('scripts')
        <script>
            function validatePhoneNumber(phoneNumber) {
                var regex = /^(\+62|62|0)(\d{8,15})$/;
                return regex.test(phoneNumber);
            }

            function validateEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            
            var new_email = document.getElementById("new_email");
            var new_phone = document.getElementById("new_phone");

            var errortextEmail = document.getElementById("errortextEmail");
            var errortextPhone = document.getElementById("errortextPhone");
            document.getElementById('changePhoneForm').addEventListener('submit', function(event) {
            event.preventDefault();

            if(new_phone.value.trim() === ""){
                errortextPhone.innerHTML = "Phone number cannot be empty";
                errortextPhone.classList.remove("hide");
            } else {
                if (!validatePhoneNumber(new_phone.value)) {
                    errortextPhone.innerHTML  = "Phone number is not valid";
                    errortextPhone.classList.remove("hide");
                } else {
                    errortextPhone.classList.add("hide");
                    document.getElementById('changePhoneForm').submit();
                    return true;
                }
            }
            return false;
        });

        document.getElementById('changeEmailForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if(new_email.value.trim() === ""){
                errortextEmail.innerHTML = "Email cannot be empty";
                errortextEmail.classList.remove("hide");
            } else {
                if (!validateEmail(new_email.value)) {
                    errortextEmail.innerHTML  = "Email is not valid";
                    errortextEmail.classList.remove("hide");
                } else {
                    errortextEmail.classList.add("hide");
                    document.getElementById('changeEmailForm').submit();
                    return true;
                }
            }
            return false;
        });
        </script>
    @endpush
@endsection