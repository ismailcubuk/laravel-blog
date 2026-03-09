<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php($siteName = $settings['site_name'] ?? config('app.name', 'My Website'))
    <title>Reset Password | {{ $siteName }}</title>
</head>
<body>
    reset password form
</body>
</html>
