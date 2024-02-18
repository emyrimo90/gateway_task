<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Forget Password Mail')}}</title>
</head>
<body>
    <h1>{{ __('Dear')}}: {{ $user['name'] }} </h1>
    <p>{{ __('Your code is')}}:  {{ $code}}</p>
</body>
</html>