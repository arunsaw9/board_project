<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .jumbotron {
            padding: 4rem 2rem;
            margin-bottom: 2rem;
            background-color: #e9ecef;
            border-radius: .3rem;
        }
        .display-4 {
            font-size: 2.5rem;
            font-weight: 300;
            line-height: 1.2;
        }
        .lead {
            font-size: 1.25rem;
            font-weight: 300;
        }
    </style>
</head>
<body>
    <div class="jumbotron">
        <h1 class="display-4">Hi, {{ $user->name }}!</h1>
        <p class="lead">Please use the OTP {{ $user->otp }} to login to the Portal.</p>
        <hr class="my-4">
        <p>This is a system generated mail. Please DO NOT reply.</p>
    </div>
</body>
</html>