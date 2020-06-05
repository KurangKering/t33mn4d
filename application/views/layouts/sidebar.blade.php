<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">


       <li><a href="{{ base_url("") }}"><i class="fa fa-circle"></i> Beranda </a></li>

       @if ($data['auth']['akses'] == 1) 
       <li><a href="{{ base_url('data-kesakitan') }}"><i class="fa fa-circle"></i> Data Penyakit </a></li>
       @elseif ($data['auth']['akses'] == 2) 
       <li><a href="{{ base_url('data-penyakit') }}"><i class="fa fa-circle"></i> Data ICD 10 </a></li>

       <li><a href="{{ base_url('data-kecamatan') }}"><i class="fa fa-circle"></i> Data Kecamatan </a></li>

       <li><a href="{{ base_url('data-puskesmas') }}"><i class="fa fa-circle"></i> Data Puskesmas </a></li>
       
       <li><a href="{{ base_url('data-treemap') }}"><i class="fa fa-circle"></i> Visual Treemap </a></li>
       
       @endif

   </li>
</ul>
</div>

</div>