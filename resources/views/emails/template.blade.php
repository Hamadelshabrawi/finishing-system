<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject }}</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2>{{ $subject }}</h2>
        <div style="margin: 20px 0;">
            {!! $content !!}
        </div>
        <footer style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px;">
            <p>©{{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>