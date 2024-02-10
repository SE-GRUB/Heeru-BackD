<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://127.0.0.1:8000/Login/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                @if(Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST" class="sign-in-form">
                    @csrf
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="number" name="nip" id="nip" placeholder="NIP" autocomplete="off" autofocus required>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" autofocus required>
                    </div>
                    <input type="submit" value="Login" class="btn solid" id="loginBtn">
                </form>
            </div>
        </div>
  
        <div class="panels-container">
            <div class="panel left-panel">
                <img src="http://127.0.0.1:8000/Login/corner-left.png" alt="left-corner" class="corner-image-left">
                <div class="content">
                    <img src="http://127.0.0.1:8000/Login/logo_white.png" alt="logo" class="logo">
                </div>
                <img src="http://127.0.0.1:8000/Login/corner-right.png" alt="right-corner" class="corner-image-right">
            </div>
    </div>


    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script>
        const login_btn = document.querySelector("#loginBtn");
        const container = document.querySelector(".container");

        login_btn.addEventListener("click", () => {
            container.classList.add("fullscreen-mode");
            setTimeout(function(){
                window.location.href = '{{route('index')}}';
            }, 1200);
        });
    </script>
</body>
</html>