<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campo Verde</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="/vendor/bootstrap/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Google Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>
  <!-- Select2 -->
  <link rel="stylesheet" href="/vendor/select2/select2.css">
  <!-- Bootstrap Datepicker -->
  <link rel="stylesheet" href="/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/vendor/admin-lte/AdminLTE.css">
  <link rel="stylesheet" href="/css/styles.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="/vendor/admin-lte/skins/skin-green-light.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-green-light sidebar-mini fixed">
<div class="wrapper">

  <!-- Main Header -->
  @include('layouts.partials.header')
  <!-- Left side column. contains the logo and sidebar -->
  @if(Auth::check())
  @include('layouts.partials.sidebar')
  @endif

<!-- Content Header (Page header) -->
    <header class="content-header">
        <h1>
            {{ isset($pageHeader) ? $pageHeader : '' }}
            <small>{{ isset($pageDescription) ? $pageDescription : '' }}</small>
        </h1>
    </header>

  <!-- Content Wrapper. Contains page content -->
  <div @if(Auth::check()) class="content-wrapper" @endif>

    @include('flash::message')

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  @include('layouts.partials.footer')

  <!-- Control Sidebar -->
  @if(Auth::check())
  @include('layouts.partials.right-sidebar')
  @endif
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="/vendor/jquery/jquery.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="/vendor/bootstrap/bootstrap.js"></script>
<!-- Select2 -->
<script src="/vendor/select2/select2.js"></script>
<!-- Bootstrap Datepicker -->
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<!-- Vue -->
<script src="/vendor/vue/vue.js"></script>
<!-- AdminLTE App -->
<script src="/vendor/admin-lte/app.js"></script>

<script type="application/javascript">
  $(function () {
    $('.btn-delete-confirmation').click(function () {
      if (confirm("Deseja realmente excluir?")) {
        $('#delete-form-' + $(this).data('delete-item-id')).submit();
      }
    });
  });
</script>

@yield('custom_scripts')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
