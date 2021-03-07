<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="/assets/dist/img/Logo-Unlam.png" type="image/gif">
  <title>@yield('title')</title>
  <!-- Moment -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="/assets/plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <script src="jquery-2.1.4.js"></script>
  <script>
   $(document).ready(function() {
  
     $("#tombol_hide").click(function() {
       $("#box").hide();
     })
  
     $("#tombol_show").click(function() {
       $("#box").show();
     })
  
   });
   </script>
   <style>
   #box {
     width: 300px;
     height: 80px;
     background-color: pink;
     border: 2px solid black;
   }
   </style>
  <style>
    .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
  </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
  <div class="wrapper">
    <!-- Navbar -->
    @include('layout.menu.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layout.menu.sidebar')
    <!-- /.Sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper text-sm">
      <!-- Main content -->
      @yield('content')
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Content Footer -->
    @include('layout.footer')
    <!-- /.content-footer -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="/assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select2 -->
  <script src="/assets/plugins/select2/js/select2.full.min.js"></script>
  <!-- Ekko Lightbox -->
  <script src="/assets/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
  <!-- DataTables -->
  <script src="/assets/plugins/datatables/jquery.dataTables.js"></script>
  <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <!-- AdminLTE App -->
  <script src="/assets/dist/js/adminlte.js"></script>
  <!-- SweetAlert2 -->
  <script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- PDFObject -->
  <script src="/assets/pdfobject.min.js"></script>

  <script>
    //tooltip
    $(function() {
      $('[data-toggle="tooltip"]').tooltip()
    })

    $(function() {
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    })
    //Initialize Select2 Elements
    $('.select2').select2()
  </script>
</body>
@yield('ajax')

</html>