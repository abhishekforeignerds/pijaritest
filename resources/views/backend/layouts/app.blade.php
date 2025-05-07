<!doctype html>
<html lang="en" class="{{ session()->get('theme_mode') }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    <!--favicon-->
    @if (!empty(appSetupValue('favicon')))
    <link rel="icon" href="{{ asset('backend/images/app_setup/' . appSetupValue('favicon')) }}" />
    @endif
    <!--plugins-->
    <link href="{{ asset('backend/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{--
    <link href="{{ asset('backend/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" /> --}}
    <!-- loader-->
    <link href="{{ asset('backend/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/bootstrap-extended.css') }}" rel="stylesheet">
    {{--
    <link href="../../../../fonts.googleapis.com/css276c7.css?family=Roboto:wght@400;500&amp;display=swap"
        rel="stylesheet"> --}}
    <link href="{{ asset('backend/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    {{--
    <link rel="stylesheet" href="{{ asset('backend/css/dark-theme.css') }}" /> --}}
    {{--
    <link rel="stylesheet" href="{{ asset('backend/css/semi-dark.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('backend/css/header-colors.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/plugins/notifications/css/lobibox.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('img_css/css/vendors.css') }}">
    <link rel="stylesheet" href="{{ asset('img_css/css/aiz-core.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="{{ asset('backend/css/dropzone.min.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <script src="{{ asset('backend/js/dropzone.min.js') }}"></script>
    <script>
        var AIZ = AIZ || {};
    </script>
    @if (!empty(appSetupValue('app_name')))
    <title>{{ appSetupValue('app_name') }} | Admin</title>
    @endif
</head>

<body>
    <!--wrapper-->
    <div class="wrapper toggled">
        @include('backend.layouts.nav')
        @include('backend.layouts.sidebar')
        @yield('content')
        @include('backend.layouts.footer')
    </div>
    <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
    <!-- ./wrapper -->
    <script src="{{ asset('backend/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->

    <script src="{{ asset('img_css/js/vendors.js') }}"></script>
    <script src="{{ asset('img_css/js/aiz-core.js') }}"></script>

    <script src="{{ asset('backend/plugins/simplebar/js/simplebar.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/plugins/metismenu/js/metisMenu.min.js')}}"></script> --}}
    <script src="{{ asset('backend/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('backend/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('backend/plugins/chartjs/js/chart.js') }}"></script>
    <script src="{{ asset('backend/plugins/select2/js/select2-custom.js') }}"></script>


    <!--app JS-->
    <script src="{{ asset('backend/js/app.js') }}"></script>
    <script>
        new PerfectScrollbar(".app-container")
    </script>
    <script src="{{ asset('backend/plugins/notifications/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/notifications/js/notifications.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/plugins/datatable/js/dataTables.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
    @yield('script')
    @foreach (['error', 'warning', 'success', 'info'] as $msg)
    @if (Session::has($msg))
    <script>
        $(function() {
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        icon: "{{ $msg }}",
                        title: "{{ Session::get($msg) }}",
                        showCloseButton: true,
                    });
                });
    </script>
    @endif
    @endforeach
    <script>
        function change_theme(mode) {
            $.get('{{ route('change_theme') }}', {
                _token: '{{ csrf_token() }}',
            }, function(data) {
                location.reload();
            });

        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the dynamically provided delete URL
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js">
    </script>
</body>

</html>