<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Borrow Me</title>

  <!-- Favicon -->
 <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Header -->
  @include('layouts/header')

  <!-- Sidebar -->
  @include('layouts/sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ $page_title ?? '' }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        
        <!-- Your Page Content Here -->
        @yield('content')      
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


 <!-- Footer -->
    @include('layouts/footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>

</body>
</html>
