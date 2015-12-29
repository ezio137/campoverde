<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Campo Verde</title>
    <meta name="description" content="description">
    <meta name="author" content="DevOOPS">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!! HTML::style('/css/vendor.css') !!}
    {{--<link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">--}}
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
    {{--<link href="plugins/fancybox/jquery.fancybox.css" rel="stylesheet">--}}
    {{--<link href="plugins/fullcalendar/fullcalendar.css" rel="stylesheet">--}}
    {{--<link href="plugins/xcharts/xcharts.min.css" rel="stylesheet">--}}
    {{--<link href="plugins/justified-gallery/justifiedGallery.css" rel="stylesheet">--}}
    {{--<link href="plugins/chartist/chartist.min.css" rel="stylesheet">--}}
    {!! HTML::style('/css/style_v1.css') !!}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
    <script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!--Start Header-->
<div id="screensaver">
    <canvas id="canvas"></canvas>
    <i class="fa fa-lock" id="screen_unlock"></i>
</div>
<div id="modalbox">
    <div class="devoops-modal">
        <div class="devoops-modal-header">
            <div class="modal-header-name">
                <span>Basic table</span>
            </div>
            <div class="box-icons">
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="devoops-modal-inner">
        </div>
        <div class="devoops-modal-bottom">
        </div>
    </div>
</div>
<header class="navbar">
    <div class="container-fluid expanded-panel">
        <div class="row">
            <div id="logo" class="col-xs-12 col-sm-2">
                <a href="index_v1.html">Campo Verde</a>
            </div>
            <div id="top-panel" class="col-xs-12 col-sm-10">
                <div class="row">
                    <div class="col-xs-8 col-sm-4">
                        <div id="search">
                            {{--<input type="text" placeholder="search"/>--}}
                            {{--<i class="fa fa-search"></i>--}}
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-8 top-panel-right">
                        {{--<a href="#" class="about">about</a>--}}
                        {{--<a href="index.html" class="style2"></a>--}}
                        <ul class="nav navbar-nav pull-right panel-menu">
                            {{--<li class="hidden-xs">--}}
                            {{--<a href="index.html" class="modal-link">--}}
                            {{--<i class="fa fa-bell"></i>--}}
                            {{--<span class="badge">7</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="hidden-xs">--}}
                            {{--<a class="ajax-link" href="ajax/calendar.html">--}}
                            {{--<i class="fa fa-calendar"></i>--}}
                            {{--<span class="badge">7</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="hidden-xs">--}}
                            {{--<a href="ajax/page_messages.html" class="ajax-link">--}}
                            {{--<i class="fa fa-envelope"></i>--}}
                            {{--<span class="badge">7</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle account" data-toggle="dropdown">
                                    <div class="avatar">
                                        {{--<img src="/img/avatar.jpg" class="img-circle" alt="avatar"/>--}}
                                    </div>
                                    <i class="fa fa-angle-down pull-right"></i>

                                    <div class="user-mini pull-right">
                                        <span class="welcome">Bem vindo,</span>
                                        <span>Fagan</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-user"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="ajax/page_messages.html" class="ajax-link">
                                            <i class="fa fa-envelope"></i>
                                            <span>Messages</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="ajax/gallery_simple.html" class="ajax-link">
                                            <i class="fa fa-picture-o"></i>
                                            <span>Albums</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="ajax/calendar.html" class="ajax-link">
                                            <i class="fa fa-tasks"></i>
                                            <span>Tasks</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-cog"></i>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-power-off"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--End Header-->
<!--Start Container-->
<div id="main" class="container-fluid">
    <div class="row">
        <div id="sidebar-left" class="col-xs-2 col-sm-2">
            <ul class="nav main-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle active">
                        <i class="fa fa-book"></i>
                        <span>Cont&aacute;bil</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/contas_contabil">Contas</a></li>
                        <li><a href="/classificacoes_contas">Classifica&ccedil;&otilde;es</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle active">
                                <i class="fa fa-book"></i>
                                <span>Balan&ccedil;o Patrimonial</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/balanco_patrimonial">Balan&ccedil;o Patrimonial (Contas)</a></li>
                                <li><a href="/balanco_patrimonial_classificacoes">Balan&ccedil;o Patrimonial (Classifica&ccedil;&otilde;es)</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--Start Content-->
        <div id="content" class="col-xs-12 col-sm-10">
            <div id="about">
                <div class="about-inner">
                    <h4 class="page-header">Open-source admin theme for you</h4>

                    <p>DevOOPS team</p>

                    <p>Homepage - <a href="http://devoops.me" target="_blank">http://devoops.me</a></p>

                    <p>Email - <a href="mailto:devoopsme@gmail.com">devoopsme@gmail.com</a></p>

                    <p>Twitter - <a href="http://twitter.com/devoopsme" target="_blank">http://twitter.com/devoopsme</a>
                    </p>

                    <p>Donate - BTC 123Ci1ZFK5V7gyLsyVU36yPNWSB5TDqKn3</p>
                </div>
            </div>
            <div class="preloader">
                <img src="img/devoops_getdata.gif" class="devoops-getdata" alt="preloader"/>
            </div>
            <div id="ajax-content">
                <div class="row">
                    <div id="breadcrumb" class="col-xs-12">
                        <a href="#" class="show-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                        <ol class="breadcrumb pull-left">
                            @yield('breadcrumb')
                        </ol>
                        <div id="social" class="pull-right">
                            {{--<a href="#"><i class="fa fa-google-plus"></i></a>--}}
                            {{--<a href="#"><i class="fa fa-facebook"></i></a>--}}
                            {{--<a href="#"><i class="fa fa-twitter"></i></a>--}}
                            {{--<a href="#"><i class="fa fa-linkedin"></i></a>--}}
                            {{--<a href="#"><i class="fa fa-youtube"></i></a>--}}
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
        <!--End Content-->
    </div>
</div>
<!--End Container-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="http://code.jquery.com/jquery.js"></script>-->
<script src="/js/vendor.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="plugins/justified-gallery/jquery.justifiedGallery.min.js"></script>
<script src="plugins/tinymce/tinymce.min.js"></script>
<script src="plugins/tinymce/jquery.tinymce.min.js"></script>
<!-- All functions for this theme + document.ready processing -->
<script src="/js/devoops.js"></script>

<script type="application/javascript">
    $('.btn-delete-confirmation').click(function () {
        if (confirm("Deseja realmente excluir?")) {
            $('#delete-form-' + $(this).data('delete-item-id')).submit();
        }
    });
</script>

@yield('custom_scripts')

</body>
</html>