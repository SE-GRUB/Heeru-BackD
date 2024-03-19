<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <p>Hi Heeroes,</p>
    <p>Welcome back to Heeroes, your safe zone! To log in to your account, please use the following One-Time Password (OTP):</p>
    {{ $otp }}
    <p>Please don't share this code with anyone for your safety.</p>
    <p>If you didn't request a login code, please contact Heeru Support immediately.</p>
    <p>See you soon,</p>
    <br>
    <br>
    <br>
    <p>The Heeroes Team</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
