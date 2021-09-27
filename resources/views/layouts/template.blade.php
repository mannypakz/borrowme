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

 {{-- Daterange Picker Styles --}}
 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <!-- Font Awesome Icons -->
  <!--<link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">-->
  <link href="{{ asset('styles.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <!-- The core Firebase JS SDK is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-database.js"></script>

  <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
  <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-analytics.js"></script>

  <script type="text/javascript">
    // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyAdJiFQvliYTBLxshWR1H7xBugGJYyLUB8",
    authDomain: "borrowme-baed6.firebaseapp.com",
    databaseURL: "https://borrowme-baed6.firebaseio.com",
    projectId: "borrowme-baed6",
    storageBucket: "borrowme-baed6.appspot.com",
    messagingSenderId: "575870363459",
    appId: "1:575870363459:web:a182704d3cb14f6162f1f6",
    measurementId: "G-SD2PC3KTXT"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
  </script>
</head>
<body class="hold-transition sidebar-mini page-{{ Route::current()->getName() }}">
<div class="wrapper">

  <!-- Header -->
  @include('layouts/mainheader')

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <!-- Content Header (Page header) -->
    @include($content_header)
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
<script src="https://kit.fontawesome.com/c2c710899b.js" crossorigin="anonymous"></script>
</body>
</html>
