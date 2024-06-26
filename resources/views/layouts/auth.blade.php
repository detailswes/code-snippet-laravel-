<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.auth.head')

    <style>
        .logo {
            background-image: url({{ getSiteLogo()}});
        }
    </style>
</head>

<body class="background no-footer ltr rounded">
    <div class="fixed-background"></div>
    <main class="default-transition">
        @yield('content')
    </main>
    <script src="{{ url('js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ url('js/dore.script.js') }}"></script>
    <script src="{{ url('js/scripts.single.theme.js') }}"></script>
    <script src="{{ url('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script>
        base_url = "{{ url('/admin') }}";
    </script>
    @stack('extra_scripts')
    <script src="{{ url('js/scripts.single.theme.js') }}"></script>
    <script src="{{ url('js/custom.js') }}"></script>
    <script>
        setTimeout(() => {
            $('#alert-box-container').fadeOut("slow");
        }, 2000);
    </script>
</body>

</html>