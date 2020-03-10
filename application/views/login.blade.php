
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login Page |</title>

  <!-- Bootstrap -->
  <link href="{{ base_url('assets/templates/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ base_url('assets/templates/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ base_url('assets/templates/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
  <!-- Animate.css -->
  <link href="{{ base_url('assets/templates/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="{{ base_url('assets/templates/build/css/custom.min.css') }}" rel="stylesheet">
</head>

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form>
            <h1>Login Form</h1>
            <div>
              <input type="text" id="username" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input type="password" id="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
             <button class="btn btn-primary" type="button" id="btn-login">Login</button>
           </div>

           <div class="clearfix"></div>

           <div class="separator">

            <div class="clearfix"></div>
            <br />


          </div>
        </form>
      </section>
    </div>


  </div>
</div>
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

    $btn_login.click(function(e) {
      $(this).attr('disabled', true);

      let post_data = {
        username: $username.val(),
        password: $password.val(),
      };

      post_data = Object.keys(post_data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(post_data[key])).join('&')

      axios.post("{{ base_url("auth/login") }}", post_data)
      .then((res) => {
        $(this).attr('disabled', false);

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
        $(this).attr('disabled', false);

      })

    });
    
  });
</script>
</body>
</html>
