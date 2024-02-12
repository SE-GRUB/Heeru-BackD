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
                        <button type="button" id="togglePassword">
                            <i class="fas fa-eye" id="showPasswordIcon"></i>
                        </button>                            
                    </div>                    
                    <span id="errortext2" class="text-danger hide">text</span>
                    <input type="button" value="Login" class="btn solid" id="loginBtn">
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
            var password = document.getElementById('password');
            var showPasswordIcon = document.getElementById("showPasswordIcon");

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
        });
    </script>
</body>
</html>