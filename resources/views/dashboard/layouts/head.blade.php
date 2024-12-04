@stack('css') 



    @if ( app()->getLocale() === 'ar')
    {{-- <link rel="stylesheet" href="{{ asset('dist-rtl/css/adminlte.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte-rtl.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    @endif
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> @yield('title') </title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Theme style -->


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


