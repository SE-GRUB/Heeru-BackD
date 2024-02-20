<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('asset/favicon.ico') }}">
    <title>@yield('title', 'Backend')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('Admin/style.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    
    <?php $useDatatables = isset($__env->getSections()['useDatatables']) ? (bool) $__env->getSections()['useDatatables'] : true; ?>

    @if($useDatatables)
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    @endif


</head>
<body>
    <nav class="close">
        <a href="{{ route('profile') }}"  class="hidden-link">
            <div class="logo-name">
                <div class="logo-image">
                    @if(Auth::check())
                    @php
                        $profilePic = Auth::user()->profile_pic ? json_decode(Auth::user()->profile_pic)[0] : null;
                    @endphp
                    
                    <img id="profile_image" src="{{ $profilePic ? asset($profilePic) : asset('Admin/images/profile.jpg') }}" alt="Gambar Profil Pengguna">            
                    @else
                        <img id="profile_image" src="{{ asset('Admin/images/profile.jpg') }}" alt="Gambar Profil Pengguna">
                    @endif
                </div>
    
                <div class="user-info">
                    @if (Auth::check())
                        @php
                            $userName = Auth::user()->name;
                            $userNameParts = explode(' ', $userName);
                            $shortenedName = $userNameParts[0];
                            if (count($userNameParts) > 1) {
                                $shortenedName .= ' ' . $userNameParts[1];
                                for ($i = 2; $i < count($userNameParts); $i++) {
                                    $shortenedName .= ' ' . substr($userNameParts[$i], 0, 1) . '.';
                                }
                            }
                        @endphp
                        <span class="logo_name">{{ $shortenedName }}</span>
                        <span class="role">{{ Auth::user()->role }}</span>
                    @else
                        <span class="logo_name">USERNAME</span>
                        <span class="role">ROLE</span>
                    @endif
                </div>
            </div>
        </a>

        <div class="menu-items">
            <ul class="nav-links">
                @if (Auth::check())
                    <li><a href="{{ route('dashboard_report.index') }}" class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                    <li><a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.index') ? 'active' : '' }}">
                        <i class="uil uil-user"></i>
                        <span class="link-name">User</span>
                    </a></li>
                    <li><a href="{{ route('program.index') }}" class="{{ request()->routeIs('program.index') ? 'active' : '' }}">
                        <i class="uil uil-book"></i>
                        <span class="link-name">Program</span>
                    </a></li>
                    <li><a href="{{ route('report_category.index') }}" class="{{ request()->routeIs('report_category.index') ? 'active' : '' }}">
                        <i class="uil uil-folder"></i>
                        <span class="link-name">Report Category</span>
                    </a></li>
                    @if (Auth::user()->role ===  "admin")
                    <li><a href="{{ route('report.index') }}" class="{{ request()->routeIs('report.index') ? 'active' : '' }}">
                        <i class="uil uil-file-graph"></i>
                        <span class="link-name">Report</span>
                    </a></li>
                    <li><a href="{{ route('post.index') }}" class="{{ request()->routeIs('post.index') ? 'active' : '' }}">
                        <i class="uil uil-postcard"></i>
                        <span class="link-name">Post</span>
                    </a></li>
                    <li><a href="{{ route('infographic.index') }}" class="{{ request()->routeIs('infographic.index') ? 'active' : '' }}">
                        <i class="uil uil-image-v"></i>
                        <span class="link-name">Infographic</span>
                    </a></li>
                    <li><a href="{{ route('consultation.index') }}" class="{{ request()->routeIs('consultation.index') ? 'active' : '' }}">
                        <i class="uil uil-heart"></i>
                        <span class="link-name">Consultation</span>
                    </a></li>
                    {{-- <li><a href="{{ route('rating.index') }}" class="{{ request()->routeIs('rating.index') ? 'active' : '' }}">
                        <i class="uil uil-heart"></i>
                        <span class="link-name">Rating</span>
                    </a></li> --}}
                    <li><a href="{{ route('payment_method.index') }}" class="{{ request()->routeIs('payment_method.index') ? 'active' : '' }}">
                        <i class="uil uil-credit-card-search"></i>
                        <span class="link-name">Payment Method</span>
                    </a></li>
                    <li><a href="{{ route('payment.index') }}" class="{{ request()->routeIs('payment.index') ? 'active' : '' }}">
                        <i class="uil uil-bill"></i>
                        <span class="link-name">Payment</span>
                    </a></li>
                    <li><a href="{{ route('status.index') }}" class="{{ request()->routeIs('status.index') ? 'active' : '' }}">
                        <i class="uil uil-share"></i>
                        <span class="link-name">Status</span>
                    </a></li>
                    @endif
                @endif
            </ul>            
            
            <ul class="logout-mode">
                <li><a href="{{route('actionlogout')}}">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                </a></li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <div class="left-top"></div>
            <div class="logoo">
                <img src="{{ asset('Admin/images/logo.png') }}" alt="HEERU">
            </div>
            <div class="date-time" id="date-time"></div>
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="row">
                    <div class="title">
                        <i class="uil uil-@yield('icon', 'Backend')"></i>
                        <span class="text">@yield('title', 'Backend')</span>
                    </div>
                    <div class="button-container">
                        <div class="button-container">
                            @yield('button')
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
            <footer>
                <p>&copy; 2024 Heeru - We Heeru</p>
            </footer>
        </div>
    </section>
    <script>
        var isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
        if (!isAuthenticated) {
            window.location.href = "{{ route('login') }}";
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if($useDatatables)
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @endif
    <script src="{{ asset('Admin/script.js') }}"></script>
    @stack('scripts')
</body>
</html>