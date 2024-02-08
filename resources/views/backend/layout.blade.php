<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Backend')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="http://127.0.0.1:8000/Admin/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>
    <nav class="close">
        <div class="logo-name">
            <div class="logo-image">
                <img src="http://127.0.0.1:8000/Admin/images/profile.jpg" alt="">
            </div>

            <span class="logo_name">Username</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="{{ Route('dashboard.index') }}">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="{{ Route('user.index') }}">
                    <i class="uil uil-user"></i>
                    <span class="link-name">User</span>
                </a></li>
                <li><a href="{{ Route('program.index') }}"">
                    <i class="uil uil-book"></i>
                    <span class="link-name">Program</span>
                </a></li>
                <li><a href="{{ Route('report.index') }}">
                    <i class="uil uil-file-graph"></i>
                    <span class="link-name">Report</span>
                </a></li>
                <li><a href="{{ Route('report_category.index') }}">
                    <i class="uil uil-folder"></i>
                    <span class="link-name">Report Category</span>
                </a></li>
                <li><a href="{{ Route('post.index') }}">
                    <i class="uil uil-postcard"></i>
                    <span class="link-name">Post</span>
                </a></li>
                <li><a href="{{ Route('infographic.index') }}">
                    <i class="uil uil-image-v"></i>
                    <span class="link-name">Infographic</span>
                </a></li>
                <li><a href="{{ Route('consultation.index') }}">
                    <i class="uil uil-heart"></i>
                    <span class="link-name">Consultation</span>
                </a></li>
                <li><a href="{{ Route('payment_method.index') }}">
                    <i class="uil uil-credit-card-search"></i>
                    <span class="link-name">Payment Method</span>
                </a></li>
                <li><a href="{{ Route('payment.index') }}">
                    <i class="uil uil-bill"></i>
                    <span class="link-name">Payment</span>
                </a></li>
                <li><a href="{{ Route('status.index') }}">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Status</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="#">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <img src="http://127.0.0.1:8000/Admin/images/logo.png" alt="HEERU">
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    {{-- <i class="uil uil-tachometer-fast-alt"></i> --}}
                    <span class="text">@yield('title', 'Backend')</span>
                </div>
                @yield('content')
            </div>
            <footer>
                <p>&copy; 2024 Heeru - We Heeru</p>
            </footer>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://127.0.0.1:8000/Admin/script.js"></script>
    <script>
        $(document).ready(function(){
            if($('#role').val() === 'student'){
                $('#studentFields').show();
                $('#picFields').show();
                $('#counselorFields').hide();
            } else if ($('#role').val() === 'pic') {
                $('#picFields').show();
                $('#studentFields').hide();
                $('#counselorFields').hide();
            } else {
                $('#studentFields').hide();
                $('#picFields').hide();
                $('#counselorFields').show();
            }
            $('#role').change(function(){
                if($(this).val() === 'student'){
                    $('#studentFields').show();
                    $('#picFields').show();
                    $('#counselorFields').hide();
                } else if ($(this).val() === 'pic') {
                    $('#picFields').show();
                    $('#studentFields').hide();
                    $('#counselorFields').hide();
                } else {
                    $('#studentFields').hide();
                    $('#picFields').hide();
                    $('#counselorFields').show();
                }
            });
        });
    </script>
</body>
</html>