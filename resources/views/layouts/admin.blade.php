<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('includes.admin.head')
    <script src="{{ url('js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ url('js/vendor/jquery-ui.min.js') }}"></script>
</head>

<body id="app-container" class="menu-default show-spinner flat">
    @include('includes.admin.navbar')
    @include('includes.admin.sidebar')

    <main>
        @yield('content')
    </main>
    @include('includes.admin.footer')

    <script src="{{ url('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('js/vendor/perfect-scrollbar.min.js') }}"></script>
    {{-- <script src="{{ url('js/vendor/bootstrap-datepicker.js') }}"></script> --}}
    <script src="{{ url('js/vendor/select2.full.js') }}"></script>

    <script src="{{ url('js/dore.script.js') }}"></script>

    <script src="{{ url('js/plugins/toastr.min.js') }}"></script>
    @stack('extra_scripts')
    <script src="{{ url('js/scripts.single.theme.js') }}"></script>
    <script src="{{ url('js/custom.js') }}"></script>
    <script>
        $("input.date").datepicker();
        setTimeout(() => {
            $('#alert-box-container').fadeOut("slow");
        }, 2000);
        base_url = "{{ url('/admin') }}";
    </script>

</body>

</html>
