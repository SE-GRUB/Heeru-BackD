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
                    @if(Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
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
                    <input type="button" value="Login" class="btn solid" id="loginBtn">
                    <a href="#" onclick="openResetPasswordModal()">Reset Password</a>
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

        login_btn.addEventListener("click", () => {
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
      
      <!-- JavaScript untuk membuka dan menutup modal serta menangani submit form -->
      <script>
        // Fungsi untuk membuka modal
        function openResetPasswordModal() {
          document.getElementById('resetPasswordModal').style.display = 'block';
        }
      
        // Fungsi untuk menutup modal
        function closeResetPasswordModal() {
          document.getElementById('resetPasswordModal').style.display = 'none';
        }
      
        // Fungsi untuk menangani submit form untuk nomor telepon
        document.getElementById('phoneForm').addEventListener('submit', function(event) {
          event.preventDefault(); // Mencegah submit form secara default
      
          // Lakukan validasi dan reset password untuk nomor telepon di sini
      
          // Tutup modal setelah submit berhasil
          closeResetPasswordModal();
        });
      
        // Fungsi untuk menangani submit form untuk email
        document.getElementById('emailForm').addEventListener('submit', function(event) {
          event.preventDefault(); // Mencegah submit form secara default
      
          // Lakukan validasi dan reset password untuk email di sini
      
          // Tutup modal setelah submit berhasil
          closeResetPasswordModal();
        });
      </script>

      <!-- Modal -->
<div id="resetPasswordModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close" onclick="closeResetPasswordModal()">&times;</span>
        <h2>Reset Password</h2>
      </div>
      <div class="tabs">
        <button class="tablinks active" onclick="openTab(event, 'phone')">Phone Number</button>
        <button class="tablinks" onclick="openTab(event, 'email')">Email</button>
      </div>
      <div id="phone" class="tabcontent">
        <form id="phoneForm">
            <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="number" name="phone_nip" id="phone_nip" placeholder="NIP" autocomplete="off" autofocus>
            </div>
            <span id="errortext3" class="text-danger hide">text</span>
            <div class="input-field">
                <i class="fas fa-phone-alt"></i>
                <input type="text" name="phone" id="phone" placeholder="Phone Number" autocomplete="off" autofocus>
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
        <form id="emailForm">
            <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="number" name="email_nip" id="email_nip" placeholder="NIP" autocomplete="off" autofocus>
            </div>
            <span id="errortext6" class="text-danger hide">text</span>
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" id="email" placeholder="Email" autocomplete="off" autofocus>
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
</body>
</html>