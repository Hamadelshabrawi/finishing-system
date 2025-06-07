<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<link rel="icon" href="{{ langAsset('favicon.ico') }}">
<title>@yield('title') | {{ config('app.name') }}</title>

<!-- Simple bar CSS -->
<link rel="stylesheet" href="{{ langAsset('css/simplebar.css') }}">
<!-- Fonts CSS -->
<link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<!-- Icons CSS -->
<link rel="stylesheet" href="{{ langAsset('css/feather.css') }}">
<link rel="stylesheet" href="{{ langAsset('css/select2.css') }}">
<link rel="stylesheet" href="{{ langAsset('css/dropzone.css') }}">
<link rel="stylesheet" href="{{ langAsset('css/uppy.min.css') }}">
<link rel="stylesheet" href="{{ langAsset('css/jquery.steps.css') }}">
<link rel="stylesheet" href="{{ langAsset('css/jquery.timepicker.css') }}">
<link rel="stylesheet" href="{{ langAsset('css/quill.snow.css') }}">
<!-- Date Range Picker CSS -->
<link rel="stylesheet" href="{{ langAsset('css/daterangepicker.css') }}">
<!-- App CSS -->

<link rel="stylesheet" href="{{ langAsset('css/app-light.css') }}" id="lightTheme">
<link rel="stylesheet" href="{{ langAsset('css/app-dark.css') }}" id="darkTheme" disabled>

<!-- RTL CSS for Arabic -->
@if(app()->getLocale() === 'ar')
    <link rel="stylesheet" href="{{ langAsset('css/rtl.css') }}">
@endif


<!-- datatables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">