<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('Login/style.css') }}">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="{{ route('actionlogin') }}" method="POST" id="formLogin" class="sign-in-form">
                    @csrf
                    @method('post')
                    @if(Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @elseif (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="number" name="nip" id="nip" placeholder="NIP" autocomplete="off" autofocus>
                    </div>
                    <span id="errortext1" class="text-danger hide">text</span>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" autofocus>
                        <button type="button" class="togglePassword" id="togglePassword">
                            <i class="fas fa-eye" id="showPasswordIcon"></i>
                        </button>                            
                    </div>                    
                    <span id="errortext2" class="text-danger hide">text</span>
                    <input type="submit" value="Login" class="btn solid" id="loginBtn">
                    <a href="#" class="reset" onclick="openResetPasswordModal()">Reset Password</a>
                </form>
            </div>
        </div>

  
        <div class="panels-container">
            <div class="panel left-panel">
                <img src="{{ asset('Login/corner-left.png') }}" alt="left-corner" class="corner-image-left">
                <div class="content">
                    <img src="{{ asset('Login/logo_white.png') }}" alt="logo" class="logo">
                </div>
                <img src="{{ asset('Login/corner-right.png') }}" alt="right-corner" class="corner-image-right">
            </div>
    </div>


    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script>
        const login_btn = document.querySelector("#loginBtn");
        const container = document.querySelector(".container");

        var nip = document.getElementById("nip");
        var password = document.getElementById("password");

        var errortext1=document.getElementById("errortext1");
        var errortext2=document.getElementById("errortext2");

        document.getElementById("formLogin").addEventListener('submit', function(event) {
            event.preventDefault();
            // container.classList.add("fullscreen-mode");
            if(nip.value.trim() === ""){
                errortext1.innerHTML="Please input your NIP";
                errortext1.classList.remove("hide");
            }else{
                errortext1.classList.add("hide");
            }

            if(password.value.trim() === ""){
                errortext2.innerHTML="Please input your Password";
                errortext2.classList.remove("hide");
            }else{
                errortext2.classList.add("hide");
                document.getElementById("formLogin").submit();
                container.classList.add("fullscreen-mode");
                setTimeout(function(){
                    window.location.href = '{{route('dashboard')}}';
                }, 1200);
                return true;
            }
            return false
        });

        document.addEventListener('DOMContentLoaded', function() {
            var togglePassword = document.getElementById('togglePassword');
            var togglePassword2 = document.getElementById('togglePassword2');
            var togglePassword3 = document.getElementById('togglePassword3');
            var password = document.getElementById('password');
            var new_password = document.getElementById('new_password');
            var new_password_email = document.getElementById('new_password_email');
            var showPasswordIcon = document.getElementById("showPasswordIcon");
            var showPasswordIcon2 = document.getElementById("showPasswordIcon2");
            var showPasswordIcon3 = document.getElementById("showPasswordIcon3");

            togglePassword.addEventListener('click', function() {
                var type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

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
                var type3 = new_password_email.getAttribute('type') === 'password' ? 'text' : 'password';
                new_password_email.setAttribute('type', type3);

                if (type3 === 'text') {
                    showPasswordIcon3.classList.remove("fa-eye");
                    showPasswordIcon3.classList.add("fa-eye-slash");
                } else {
                    showPasswordIcon3.classList.remove("fa-eye-slash");
                    showPasswordIcon3.classList.add("fa-eye");
                }
            });
        });
    </script>
    <!-- Modal -->
<div id="resetPasswordModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
          <div class="modal-title">
              <h2>Reset Password</h2>
            </div>
        <span class="close" onclick="closeResetPasswordModal()">&times;</span>
      </div>
      <div class="tabs">
        <button class="tablinks active" onclick="openTab(event, 'phone')">Phone Number</button>
        <button class="tablinks" onclick="openTab(event, 'email')">Email</button>
      </div>
      <div id="phone" class="tabcontent">
        <form id="phoneForm" method="POST" action="{{ route('reset.phone') }}">
            @csrf
            @method('post')
            <div class="note">
                <span><b>Note: </b><br>Phone Number Inserted  Must Be Registered With Us.</span><br>
                <em>Nomor telepon yang dimasukkan adalah nomor telepon yang telah didaftarkan.</em></span>
            </div>
            <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="number" name="phone_nip" id="phone_nip" placeholder="NIP" autocomplete="off" autofocus>
            </div>
            <span id="errortext3" class="text-danger hide">text</span>
            <div class="input-field">
                <i class="fas fa-phone-alt"></i>
                <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" autocomplete="off" autofocus>
            </div>
            <span id="errortext4" class="text-danger hide">text</span>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="new_password" id="new_password" placeholder="New Password" autocomplete="off" autofocus>
                <button type="button" class="togglePassword" id="togglePassword2">
                    <i class="fas fa-eye" id="showPasswordIcon2"></i>
                </button>                            
            </div>                    
            <span id="errortext5" class="text-danger hide">text</span>
          <button class="btn solid" type="submit">Reset Password</button>
        </form>
      </div>
      <div id="email" class="tabcontent" style="display: none;">
        <form id="emailForm" action="{{ route('reset.email') }}" method="POST">
            @csrf
            @method('post')
            <div class="note">
                <span><b>Note: </b><br>Email Inserted  Must Be Registered With Us.</span><br>
                <em>Email yang dimasukkan adalah email yang telah didaftarkan.</em></span>
            </div>
            <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="number" name="email_nip" id="email_nip" placeholder="NIP" autocomplete="off" autofocus>
            </div>
            <span id="errortext6" class="text-danger hide">text</span>
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email_reset" id="email_reset" placeholder="Email" autocomplete="off" autofocus>
            </div>
            <span id="errortext7" class="text-danger hide">text</span>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="new_password_email" id="new_password_email" placeholder="New Password" autocomplete="off" autofocus>
                <button type="button" class="togglePassword" id="togglePassword3">
                    <i class="fas fa-eye" id="showPasswordIcon3"></i>
                </button>                            
            </div>                    
            <span id="errortext8" class="text-danger hide">text</span>
          <button class="btn solid" type="submit">Reset Password</button>
        </form>
      </div>
    </div>
  </div>
    <script>
        function openTab(evt, tabName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(tabName).style.display = "block";
          evt.currentTarget.className += " active";
        }
      </script>
      <script>
        function openResetPasswordModal() {
          document.getElementById('resetPasswordModal').style.display = 'block';
        }
        function closeResetPasswordModal() {
          document.getElementById('resetPasswordModal').style.display = 'none';
        }

        function validatePhoneNumber(phoneNumber) {
            var regex = /^(\+62|62|0)(\d{8,15})$/;
            return regex.test(phoneNumber);
        }

        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
      
        // Fungsi untuk menangani submit form untuk nomor telepon
        document.getElementById('phoneForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var nip = document.getElementById("phone_nip");
            var no_telp = document.getElementById("phone_number");
            var new_password = document.getElementById("new_password");

            var errortext3 = document.getElementById("errortext3");
            var errortext4 = document.getElementById("errortext4");
            var errortext5 = document.getElementById("errortext5");

            if(nip.value.trim() === ""){
                errortext3.innerHTML = "NIP cannot be empty";
                errortext3.classList.remove("hide");
            } else {
                errortext3.classList.add("hide");
            }

            if(no_telp.value.trim() === ""){
                errortext4.innerHTML = "Phone number cannot be empty";
                errortext4.classList.remove("hide");
            } else {
                errortext4.classList.add("hide");
                if (validatePhoneNumber(no_telp.value)) {
                    if (no_telp.value.startsWith('+62')) {
                        no_telp.value = '0' + no_telp.value.substring(3);
                    }
                    errortext4.classList.add("hide");
                } else {
                    errortext4.innerHTML  = "Phone number is not valid";
                    errortext4.classList.remove("hide");
                }
            }

            if(new_password.value.trim() === ""){
                errortext5.innerHTML = "Password cannot be empty";
                errortext5.classList.remove("hide");
            } else {
                errortext5.classList.add("hide");
                if(!/[A-Z]/.test(new_password.value)){
                    errortext5.innerText = "Your password must contain at least one uppercase letter";
                    errortext5.classList.remove("hide");
                } else {
                    if (new_password.value.length < 8 ) {
                        errortext5.innerHTML = "Password must be at least 8 characters long";
                        errortext5.classList.remove("hide");
                    } else {
                        if(!/[a-z]/.test(new_password.value)){
                            errortext5.innerText = "Your password must contain at least one lowercase letter";
                            errortext5.classList.remove("hide");
                        } else {
                            if(!/\d/.test(new_password.value)){
                                errortext5.innerText = "Your password must contain at least one number.";
                                errortext5.classList.remove("hide");
                            } else {
                                errortext5.classList.add('hide');
                                document.getElementById('phoneForm').submit();
                                return true;
                            }
                        }
                    }
                }
            }
            return false;
        });
      
        // Fungsi untuk menangani submit form untuk email
        document.getElementById('emailForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var email_nip = document.getElementById("email_nip");
            var email = document.getElementById("email_reset");
            var new_password_email = document.getElementById("new_password_email");

            var errortext6 = document.getElementById("errortext6");
            var errortext7 = document.getElementById("errortext7");
            var errortext8 = document.getElementById("errortext8");

            if(email_nip.value.trim() === ""){
                errortext6.innerHTML = "NIP cannot be empty";
                errortext6.classList.remove("hide");
            } else {
                errortext6.classList.add("hide");
            }

            if(email.value.trim() === ""){
                errortext7.innerHTML = "Email cannot be empty";
                errortext7.classList.remove("hide");
            } else {
                errortext7.classList.add("hide");
                if (validateEmail(email.value)) {
                    errortext7.classList.add("hide");
                } else {
                    errortext7.innerHTML  = "Email is not valid";
                    errortext7.classList.remove("hide");
                }
            }

            if(new_password_email.value.trim() === ""){
                errortext8.innerHTML = "Password cannot be empty";
                errortext8.classList.remove("hide");
            } else {
                errortext8.classList.add("hide");
                if(!/[A-Z]/.test(new_password_email.value)){
                    errortext8.innerText = "Your password must contain at least one uppercase letter";
                    errortext8.classList.remove("hide");
                } else {
                    if (new_password_email.value.length < 8 ) {
                        errortext8.innerHTML = "Password must be at least 8 characters long";
                        errortext8.classList.remove("hide");
                    } else {
                        if(!/[a-z]/.test(new_password_email.value)){
                            errortext8.innerText = "Your password must contain at least one lowercase letter";
                            errortext8.classList.remove("hide");
                        } else {
                            if(!/\d/.test(new_password_email.value)){
                                errortext8.innerText = "Your password must contain at least one number.";
                                errortext8.classList.remove("hide");
                            } else {
                                errortext8.classList.add('hide');
                                document.getElementById('emailForm').submit();
                                return true;
                            }
                        }
                    }
                }
            }
            return false;
        });
      </script>
</body>
</html>