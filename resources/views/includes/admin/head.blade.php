<meta charset="UTF-8" />
<title> Admin | @yield('title')</title>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="{{ url('font/iconsmind-s/css/iconsminds.css') }}" />
<link rel="stylesheet" href="{{ url('font/simple-line-icons/css/simple-line-icons.css') }}" />
<link rel="stylesheet" href="{{ url('css/vendor/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ url('css/vendor/bootstrap-datepicker3.min.css') }}" />
<link rel="stylesheet" href="{{ url('css/vendor/select2.min.css') }}" />
<link rel="stylesheet" href="{{ url('css/vendor/select2-bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ url('css/vendor/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ url('css/vendor/component-custom-switch.min.css') }}" />
<link rel="stylesheet" href="{{ url('css/dore.light.blue.min.css') }}" />

<link rel="stylesheet" href="{{ url('css/all.min.css') }}" />
<link rel="stylesheet" href="{{ url('css/main.css') }}" />
<link rel="stylesheet" href="{{ url('css/plugins/toastr.min.css') }}" />
@stack('styles')
<link rel="stylesheet" href="{{ url('css/custom.css') }}" />
<link rel="stylesheet" href="{{ url('css/style.css') }}" />
