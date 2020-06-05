
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>#</title>

  <!-- Bootstrap -->
  <link href="{{ base_url('assets/templates/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ base_url('assets/templates/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ base_url('assets/templates/vendors/nprogress/nprogress.css') }}" rel="stylesheet">

  <link href="{{ base_url('assets/templates/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ base_url('assets/templates/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ base_url('assets/templates/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ base_url('assets/templates/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ base_url('assets/templates/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
  <style>

    .gambar-penuh {
      width: 80% !important;
    }
  </style>
  @yield('css-export')


  <!-- Custom Theme Style -->
  <link href="{{ base_url('assets/templates/build/css/custom.min.css') }}" rel="stylesheet">
  @yield('css-inline')

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
           {{--  <a href="javascript:void(0);" class="site_title"><i class="fa fa-paw"></i> 

           </a> --}}
           <div class="site_title">

             <a href="{{ base_url() }}" style="color: inherit;">
              <img id="logo-kiri" style="width: 25%; height: 100%;" src="{{ base_url('assets/images/kampar.png') }}">
              <span>SISKES</span>
            </a>


          </div>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
          <div class="profile_pic">
            <img src="{{ base_url('assets/images/unknown_profile.png') }}" alt="..." class="img-circle profile_img">
          </div>
          <div class="profile_info">
            <span>Welcome,</span>
            <h2>{{ $data['auth']['role'] }}</h2>
          </div>
          <div class="clearfix"></div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        @include('layouts.sidebar')
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->

        <!-- /menu footer buttons -->
      </div>
    </div>

    <!-- top navigation -->
    <div class="top_nav">
      <div class="nav_menu">
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
          <ul class=" navbar-right">

           <li class="nav-item " style="margin-right: 15px;">

             <a href="{{ base_url('logout') }}">Logout</a>
           </li>

         </ul>
       </nav>
     </div>
   </div>
   <!-- /top navigation -->

   <!-- page content -->
   <div class="right_col" role="main">
    @yield('content')
  </div>
  <!-- /page content -->

  <!-- footer content -->
  <footer>
    <div class="pull-right">
      Gentelella - Bootstrap Admin Template by <a href="{{ base_url('assets/templates/https://colorlib.com') }}">Colorlib</a>
    </div>
    <div class="clearfix"></div>
  </footer>
  <!-- /footer content -->
</div>
</div>

<!-- jQuery -->
<script src="{{ base_url('assets/templates/vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ base_url('assets/templates/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ base_url('assets/templates/vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ base_url('assets/templates/vendors/nprogress/nprogress.js') }}"></script>

<script src="{{ base_url('assets/axios.min.js') }}"></script>
<script src="{{ base_url('assets/sweetalert2.all.min.js') }}"></script>


<script src="{{ base_url('assets/templates/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
<script src="{{ base_url('assets/templates/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
<script src="{{ base_url('assets/jquery_chained-2.x/jquery.chained.min.js') }}"></script>

@yield('js-export')
<!-- Custom Theme Scripts -->
<script src="{{ base_url('assets/templates/build/js/custom.min.js') }}"></script>
@yield('js-inline')
</body>
</html>
