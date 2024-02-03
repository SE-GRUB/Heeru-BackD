<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Backend')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #343a40;
            color: #ffffff;
            height: 100vh;
            position: fixed;
            width: 250px;
            padding-top: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px;
        }

        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .sidebar a:hover {
            color: #007bff;
        }

        .sidebar li.active a {
            color: #007bff;
            font-weight: bold;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            /* overflow-y: scroll; */
        }

        header {
            /* background-color: #343a40;
            color: #ffffff; */
            padding: 10px;
            margin-bottom: 20px;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #343a40;
            color: #ffffff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}"><a href="{{ Route('dashboard.index') }}">Dashboard</a></li>
            <li class="{{ request()->routeIs('user.index') ? 'active' : '' }}"><a href="{{ Route('user.index') }}">User</a></li>
            <li class="{{ request()->routeIs('program.index') ? 'active' : '' }}"><a href="{{ Route('program.index') }}">Program</a></li>
            <li class="{{ request()->routeIs('report.index') ? 'active' : '' }}"><a href="{{ Route('report.index') }}">Report</a></li>
            <li class="{{ request()->routeIs('report_category.index') ? 'active' : '' }}"><a href="{{ Route('report_category.index') }}">Report Categories</a></li>
            <li class="{{ request()->routeIs('post.index') ? 'active' : '' }}"><a href="{{ Route('post.index') }}">Post</a></li>
            <li class="{{ request()->routeIs('infographic.index') ? 'active' : '' }}"><a href="{{ Route('infographic.index') }}">Infographic</a></li>
            <li class="{{ request()->routeIs('consultation.index') ? 'active' : '' }}"><a href="{{ Route('consultation.index') }}">Consultation</a></li>
            <li class="{{ request()->routeIs('payment_method.index') ? 'active' : '' }}"><a href="{{ Route('payment_method.index') }}">Payment Method</a></li>
            <li class="{{ request()->routeIs('payment.index') ? 'active' : '' }}"><a href="{{ Route('payment.index') }}">Payment</a></li>
            <li class="{{ request()->routeIs('status.index') ? 'active' : '' }}"><a href="{{ Route('status.index') }}">Status</a></li>

        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Header -->
        <header>
            <h1>@yield('title', 'Backend')</h1>
        </header>

        <!-- Index Section -->
        <section class="index mb-5">
            @yield('content')
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Heeru - We Heeru</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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