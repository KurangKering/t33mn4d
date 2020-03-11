<html>
<head>
 <style>
  @page { margin-top: 5px; }
  body {
    font-family: 'Times New Roman';
    font-weight: 400;
    font-size: 14px;
    line-height: 1.42857143;
    margin-bottom: 0;

  }

  *,
  *:before,
  *:after {
    color: #000 !important;
    text-shadow: none !important;
    background: transparent !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
  }
  
  thead {
    display: table-header-group;
  }
  tr,
  img {
    page-break-inside: avoid;
  }
  img {
    max-width: 100% !important;
  }
  p,
  h2,
  h3 {
    orphans: 3;
    widows: 3;
  }
  h2,
  h3 {
    page-break-after: avoid;
  }

  .table {
    border-collapse: collapse !important;
  }
  .table td,
  .table th {
    background-color: #fff !important;
  }
  .table-bordered th,
  .table-bordered td {
    border: 1px solid #ddd !important;
  }

  img {
    border: 0;
  }
  table {
    border-spacing: 0;
    border-collapse: collapse;
  }
  td,
  th {
    padding: 0;
  }
  /*! Source: https://github.com/h5bp/html5-boilerplate/blob/master/src/css/main.css */
  @media print {
    *,
    *:before,
    *:after {
      color: #000 !important;
      text-shadow: none !important;
      background: transparent !important;
      -webkit-box-shadow: none !important;
      box-shadow: none !important;
    }

    thead {
      display: table-header-group;
    }
    tr,
    img {
      page-break-inside: avoid;
    }
    img {
      max-width: 100% !important;
    }
    p,
    h2,
    h3 {
      orphans: 3;
      widows: 3;
    }
    h2,
    h3 {
      page-break-after: avoid;
    }

    .table {
      border-collapse: collapse !important;
    }
    .table td,
    .table th {
      background-color: #fff !important;
    }
    .table-bordered th,
    .table-bordered td {
      border: 1px solid #ddd !important;
    }
  }
  h1,
  h2,
  h3,
  h4,
  h5,
  h6,
  .h1,
  .h2,
  .h3,
  .h4,
  .h5,
  .h6 {
    font-family: inherit;
    font-weight: 500;
    line-height: 1.1;
    color: inherit;
  }
  h1 small,
  h2 small,
  h3 small,
  h4 small,
  h5 small,
  h6 small,
  .h1 small,
  .h2 small,
  .h3 small,
  .h4 small,
  .h5 small,
  .h6 small,
  h1 .small,
  h2 .small,
  h3 .small,
  h4 .small,
  h5 .small,
  h6 .small,
  .h1 .small,
  .h2 .small,
  .h3 .small,
  .h4 .small,
  .h5 .small,
  .h6 .small {
    font-weight: normal;
    line-height: 1;
    color: #777;
  }
  h1,
  .h1,
  h2,
  .h2,
  h3,
  .h3 {
    margin-top: 20px;
    margin-bottom: 10px;
  }
  h1 small,
  .h1 small,
  h2 small,
  .h2 small,
  h3 small,
  .h3 small,
  h1 .small,
  .h1 .small,
  h2 .small,
  .h2 .small,
  h3 .small,
  .h3 .small {
    font-size: 65%;
  }
  h4,
  .h4,
  h5,
  .h5,
  h6,
  .h6 {
    margin-top: 10px;
    margin-bottom: 10px;
  }
  h4 small,
  .h4 small,
  h5 small,
  .h5 small,
  h6 small,
  .h6 small,
  h4 .small,
  .h4 .small,
  h5 .small,
  .h5 .small,
  h6 .small,
  .h6 .small {
    font-size: 75%;
  }
  h1,
  .h1 {
    font-size: 36px;
  }
  h2,
  .h2 {
    font-size: 30px;
  }
  h3,
  .h3 {
    font-size: 24px;
  }
  h4,
  .h4 {
    font-size: 18px;
  }
  h5,
  .h5 {
    font-size: 14px;
  }
  h6,
  .h6 {
    font-size: 12px;
  }
  p {
    margin: 0 0 10px;
  }

  .text-left {
    text-align: left;
  }
  .text-right {
    text-align: right;
  }
  .text-center {
    text-align: center;
  }
  .text-justify {
    text-align: justify;
  }
  .text-nowrap {
    white-space: nowrap;
  }

  .text-muted {
    color: #777;
  }
  .text-primary {
    color: #337ab7;
  }

  table {
    background-color: transparent;
  }

  th {
    text-align: left;
  }
  .table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
  }
  .table > thead > tr > th,
  .table > tbody > tr > th,
  .table > tfoot > tr > th,
  .table > thead > tr > td,
  .table > tbody > tr > td,
  .table > tfoot > tr > td {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
  }
  .table > thead > tr > th {
    vertical-align: bottom;
    border-bottom: 2px solid #ddd;
  }
  .table > caption + thead > tr:first-child > th,
  .table > colgroup + thead > tr:first-child > th,
  .table > thead:first-child > tr:first-child > th,
  .table > caption + thead > tr:first-child > td,
  .table > colgroup + thead > tr:first-child > td,
  .table > thead:first-child > tr:first-child > td {
    border-top: 0;
  }
  .table > tbody + tbody {
    border-top: 2px solid #ddd;
  }
  .table .table {
    background-color: #fff;
  }

  .table-bordered {
    border: 1px solid #ddd;
  }
  .table-bordered > thead > tr > th,
  .table-bordered > tbody > tr > th,
  .table-bordered > tfoot > tr > th,
  .table-bordered > thead > tr > td,
  .table-bordered > tbody > tr > td,
  .table-bordered > tfoot > tr > td {
    border: 1px solid #ddd;
  }
  .table-bordered > thead > tr > th,
  .table-bordered > thead > tr > td {
    border-bottom-width: 2px;
  }
  

  /*# sourceMappingURL=bootstrap.css.map */



</style>
</head>
<body>
  <h3 class="text-center">Data Kesakitan</h3>  
  <h5 class="text-center"><?= $data['subtitle'] ?></h5>  
  <br>
  <table class="table table-bordered">
    <thead>
     <tr>
      <th>No</th>
      <th>Tahun</th>
      <th>Bulan</th>
      <th>Penyakit</th>
      <th>Puskesmas</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $no = 1;
   $total = 0;
   ?>
   <?php foreach ($data['kesakitan'] as $k => $kesakitan): ?>
    <tr>
     <td><?= $no++ ?></td>
     <td><?= $kesakitan->kesakitan_tahun ?></td>
     <td><?= $kesakitan->bulan ?></td>
     <td><?= $kesakitan->penyakit_nama ?></td>
     <td><?= $kesakitan->puskesmas_nama ?></td>
     <td><?= $kesakitan->kesakitan_jumlah ?></td>
   </tr>
   <?php
   $total += $kesakitan->kesakitan_jumlah
   ?>

 <?php endforeach ?>
 <tr>
   <td colspan="5" style="text-align: right;font-weight: bold;">Total :</td>
   <td><?php echo $total ?></td>
 </tr>
</tbody>

</table>
<script src="<?= base_url('assets/templates/vendors/jquery/dist/jquery.min.js') ?>"></script>

<script>
 $(document).ready(function() {
   window.print();
 });
</script>
</body>
</html>