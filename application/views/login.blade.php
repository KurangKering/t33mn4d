
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login Page |</title>

  <link href="{{ base_url('assets/templates/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ base_url('assets/templates/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ base_url('assets/css/login.css') }}" />
  <link href="{{ base_url('assets/templates/build/css/custom.min.css') }}" rel="stylesheet">


  <!--inline styles related to this page-->
  <style type="text/css">
    .login-layout {
      background: #ffffff;
      background-image: url("{{ base_url('assets/images/back.jpg') }}");


    }

  </style>
</head>

<body class="login-layout">
  <div class="main-container container-fluid">
    <div class="main-content">
      <div class="row-fluid">
        <div class="span12">
          <div class="login-container">


            <div class="row-fluid">
              <div class="position-relative">

                <div id="login-box" class="login-box visible widget-box no-border">
                  <div class="widget-body">

                    <div class="widget-main">

                      <div id="label-perusahaan">
                        <h4>SISTEM INFORMASI PENYAKIT MENULAR DAN TIDAK MENULAR KABUPATEN KAMPAR</h4>

                      </div>
                      <div id="logo">
                        <img src="{{ base_url('assets/images/kampar.png') }}" class="img-polaroid"/>
                      </div>

                      <form id="form-login">
                        <fieldset>
                          <div class="form-group">
                            <label class="block clearfix">
                              <span class="block input-icon input-icon-right">
                                <input required id="username" name="username" type="text" class="span12" placeholder="Username" autocomplete="off" autofocus />
                                <i class="icon-user"></i>
                              </span>
                            </label>
                          </div>

                          <div class="form-group">
                            <label class="block clearfix">
                              <span class="block input-icon input-icon-right">
                                <input required id="password" name="password" type="password" class="span12" placeholder="Password" autocomplete="off" />
                                <i class="icon-lock"></i>
                              </span>
                            </label>
                          </div>
                            <!--
                            <div class="form-group">
                            <label class="block clearfix">
                              <label>Tahun Anggaran</label>
                              <select  placeholder="Tahun Anggaran..." style="width:100%;">
                                <option value="AL" />2016
                                <option value="AK" />2017
                                <option value="AZ" />2018
                              </select>
                            </label>
                            </div>
                          -->
                          <div class="form-group">


                            <button id="btn-login" class="width-35 pull-right btn btn-small btn-primary" type="submit">
                              <i class="icon-key"></i>
                              Login
                            </button>
                          </div>


                        </fieldset>
                      </form>


                    </div><!--/widget-main-->

                    
                  </div><!--/widget-body-->
                </div><!--/login-box-->

                <!--/forgot-box-->

                <!--/signup-box-->
              </div><!--/position-relative-->
            </div>
          </div>
        </div><!--/.span-->
      </div><!--/.row-fluid-->
    </div>
  </div><!--/.main-container-->

  <!--basic scripts-->
  <script src="{{ base_url('assets/templates/vendors/jquery/dist/jquery.min.js') }}"></script>

  <script src="{{ base_url('assets/axios.min.js') }}"></script>
  <script src="{{ base_url('assets/sweetalert2.all.min.js') }}"></script>
  <script>
   let $btn_login = null;
   let $username = null;
   let $password = null;

   $(function() {
    $btn_login = $("#btn-login");
    $username = $("#username");
    $password = $("#password");

    $("#form-login").submit(function(e) {

      e.preventDefault();

      $(this).find(':submit').attr('disabled','disabled');


      let post_data = {
        username: $username.val(),
        password: $password.val(),
      };

      post_data = Object.keys(post_data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(post_data[key])).join('&')

      axios.post("{{ base_url("auth/login") }}", post_data)
      .then((res) => {
      $(this).find(':submit').attr('disabled',false);


        response = res.data;

        if (response.success == 0) {
         Swal.fire({
          title: 'Gagal!',
          text: response.message,
          icon: 'error',
          timer: 1000,
          showConfirmButton: false,

        });
       } else {
        window.location.href = "{{ base_url('') }}";
      }

    })
      .catch(() => {
      $(this).find(':submit').attr('disabled',false);


      })

    });
    
  });
</script>
</body>

</html>
