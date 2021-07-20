<!doctype html>
<html class="no-js " lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <title>@yield('title','')</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/plugins/charts-c3/plugin.css') }}" />

    <link rel="stylesheet" href="{{ asset('backend/plugins/morrisjs/morris.min.css') }}" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/dropify/css/dropify.min.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/local.css') }}">

    @include('admin.layouts.css')
    @yield('css')

</head>

<body class="theme-blush">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('backend/images/loader.svg') }}" width="48" height="48" alt="Aero"></div>
            <p>Please wait...</p>
        </div>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Left Sidebar -->
    @include('admin.layouts.menu')
    <section class="content">
        <div class="body_scroll">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <h2>
                            <button class="btn btn-primary mr-3 " type="button" data-toggle="modal" data-target="#menumodal">Menu</button> <a href="{{route('admin.dashboard')}}">Dashboard</a> / @yield('head-title','')
                        </h2>
                        <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12">

                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <div>
                                    @yield('toobar')
                                </div>
                            </div>
                            <div class="body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="window " id="window">
        <div class="inner-window">
            <div class="top-bar">
                <span id="wt">

                </span>
                <span id="wcc" onclick="win.hide()">
                    close
                </span>
            </div>
            <div class="content" id="wc">

            </div>
        </div>
    </div>


    <div class="modal fade" id="menumodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg p-0 m-0" role="document" style="max-width:100vw;">
          <div class="modal-content">
            <div class="modal-header pb-3">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="top:5px;font-size:3rem;">
                  <span aria-hidden="true" >&times;</span>
                </button>
            </div>
            <div class="modal-body pt-1">
                @include('admin.modalmenu')
            </div>
          </div>
        </div>
      </div>
      @include('admin.layouts.working')
    <!-- Jquery Core Js -->
    <script>
        const printcss ='{{ asset("backend/css/print.css") }}';
    </script>
    <script src="{{ asset('backend/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="{{ asset('backend/bundles/vendorscripts.bundle.js') }}"></script> <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="{{ asset('backend/bundles/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{ asset('backend/bundles/sparkline.bundle.js') }}"></script> <!-- Sparkline Plugin Js -->
    <script src="{{ asset('backend/bundles/c3.bundle.js') }}"></script>

    <script src="{{ asset('backend/plugins/jquery-validation/jquery.validate.js') }}"></script> <!-- Jquery Validation Plugin Css -->
    <script src="{{ asset('backend/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script> <!-- Bootstrap Notify Plugin Js -->

    <script src="{{ asset('backend/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('backend/js/pages/forms/form-validation.js') }}"></script>
    <script src="{{ asset('backend/js/pages/ui/notifications.js') }}"></script> <!-- Custom Js -->


    <!-- <script src="{{ asset('backend/js/pages/index.js') }}"></script> -->
    <script src="{{ asset('backend/js/axios.js') }}"></script>
    <script src="{{ asset('backend/js/table.js') }}"></script>
    <script src="{{ asset('backend/js/input.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.hotkeys.js') }}"></script>

    @include('admin.layouts.ledgerjs')

    @yield('js')
    @yield('js1')
    @yield('js2')
    @yield('js3')
    @yield('js4')
    @yield('js5')
</body>

</html>
