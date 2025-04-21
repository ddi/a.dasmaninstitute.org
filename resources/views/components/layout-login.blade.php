<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="/" />
    <title>{{ $title ?? 'Medical' }}</title>
    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/regular.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/brands.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/solid.css">
    <!-- include vendor stylesheets used in "Login" page. see "/views//pages/partials/page-login/@vendor-stylesheets.hbs" -->
    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="./dist/css/ace-font.css">
    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="./dist/css/ace.css">
    <!-- favicon -->
    <link rel="icon" type="image/png" href="./assets/favicon.png" />
    <!-- "Login" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="./views/pages/page-login/@page-style.css">
</head>

<body>
    <div class="body-container">
        <div class="main-container container bgc-transparent">
            <div class="main-content justify-content-center">
                <div class="row justify-content-center">
                    <div class="col-6 bgc-white shadow radius-1 overflow-hidden">
                        <div class="row">
                            <div class="col-lg-12 py-lg-5 bgc-white px-0">
                                <div class="mh-100 px-3 px-lg-0 pb-3">
                                    <!-- show this in desktop -->
                                    <div class="d-none d-lg-block col-md-6 offset-md-3 mt-lg-4 px-0">
                                        <h4 class="text-dark-tp4 border-b-1 brc-secondary-l2 pb-1 text-130">
                                            <i class="fa fa-lock text-blue-m1 mr-1"></i>
                                            DDI Account Only (first.last)
                                        </h4>
                                    </div>

                                    <!-- show this in mobile device -->
                                    <div class="d-lg-none text-secondary-m1 my-4 text-center">
                                        <a href="html/dashboard.html">
                                            <i class="fa fa-leaf text-success-m2 text-200 mb-4"></i>
                                        </a>
                                        <h1 class="text-170">
                                            <span class="text-blue-d1">
                                                DDI <span class="text-80 text-dark-tp3">Application</span>
                                            </span>
                                        </h1>
                                        DDI Account Only (first.last)
                                    </div>
                                    {{ $slot }}
                                </div>
                            </div>
                        </div><!-- /.row -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div>
    </div>
    <!-- include common vendor scripts used in demo pages -->
    <script src="./node_modules/jquery/dist/jquery.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <!-- include vendor scripts used in "Login" page. see "/views//pages/partials/page-login/@vendor-scripts.hbs" -->
    <!-- include ace.js -->
    <script src="./dist/js/ace.js"></script>
</body>

</html>
