<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">
    {{--   <li><a><i class="fa fa-home"></i> Das <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ base_url('assets/templates/index.html') }}">Dashboard</a></li>
          <li><a href="{{ base_url('assets/templates/index2.html') }}">Dashboard2</a></li>
          <li><a href="{{ base_url('assets/templates/index3.html') }}">Dashboard3</a></li>
        </ul>
      </li> --}}
       <li><a><i class="fa fa-home"></i> Dashboard </a>
       <li><a href="{{ base_url('data-penyakit') }}"><i class="fa fa-home"></i> Data Penyakit </a>
       <li><a href="{{ base_url('data-kecamatan') }}"><i class="fa fa-home"></i> Data Kecamatan </a>
       <li><a href="{{ base_url('data-puskesmas') }}"><i class="fa fa-home"></i> Data Puskesmas </a>
       <li><a href="{{ base_url('data-pasien') }}"><i class="fa fa-home"></i> Data Pasien </a>
       <li><a href="{{ base_url('data-kesakitan') }}"><i class="fa fa-home"></i> Data Kesakitan </a>
       <li><a href="{{ base_url('data-treemap') }}"><i class="fa fa-home"></i> Visual Treemap </a>
      </li>
    </ul>
  </div>

</div>