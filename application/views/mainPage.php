<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Simcard Log View</title>
  <!-- MDB icon -->
  <link rel="icon" href="<?php echo base_url().'assets/img/mdb-favicon.ico'?>" type="image/x-icon">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.min.css'?>">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/css/mdb.min.css'?>">
  <!-- Your custom styles (optional) -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/css/style.css'?>">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/css/toastr.min.css'?>">
</head>
<body>

  <!-- Start your project here-->  
<div class="container my-5 z-depth-2">


  <!--Section: Content-->
  <section class="dark-grey-text">

    <div class="row pr-lg-12">

      <div class="col-md-7">

        <div class="view">
          <img src="<?php echo base_url().'assets/img/logo.png'?>" class="img-fluid" alt="smaple image" style="height: 350px; width: 1000px;">
        </div>

      </div>
      
      <div class="col-md-5 align-self-center">
            
            <!-- Default form login -->
          <form action="#!" style="padding-right: 80px;">

            <p class="h4 mb-4">Log in</p>

            <!-- Material outline input -->
            <div class="md-form md-outline">
              <input type="text" id="uname" class="form-control">
              <label for="form1">Username</label>
            </div>
 
            <div class="md-form md-outline">
              <input type="password" id="password" class="form-control">
              <label for="form2">Password</label>
            </div>

            <!-- Sign in button -->
            <button class="btn btn-primary btn-block my-4" id="btn-login" type="button">Log in</button>

          </form>
          <!-- Default form login -->
          
      </div>

    </div>

  </section>
  <!--Section: Content-->

</div>
  <!-- End your project here-->


  <!-- jQuery -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/popper.min.js'?>"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/mdb.min.js'?>"></script>
  <!-- Toastr -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/toastr.min.js'?>"></script>

  <!-- Your custom scripts (optional) -->
  <script type="text/javascript">
    
    let baseURL = '<?php echo base_url(); ?>';

    $(document).ready(function(){

      $('#btn-login').click(function(){

        let username = $('#uname').val();
        let password = $('#password').val();

        $.ajax({

          url     : 'doLogin',
          method  : 'post',
          data    : {username : username, password : password},
          dataType: 'json',
          success : function(response){
              
              if(response['response']['is_user'] == 200){

                  if(response['response']['is_login'] === false){

                    localStorage.setItem("userName", response['response']['user_name']);
                    localStorage.setItem("loginTime", response['response']['login_time']);
                    localStorage.setItem("userIP", response['response']['user_ip']);

                    window.location.href = baseURL+response['response']['route_page'];

                  } else {

                      toastr.error('User sudah login di IP '+response['response']['user_ip']);

                  }

              } else {

                toastr.warning('Username atau password tidak sesuai, silahkan coba lagi');

              }


          },
          error   : function(Err, xhr, status){

              toastr.warning('Telah terjadi error, mohon ulangi proses');              

          }

        });
        
        return false;

      });

    });


  </script>

</body>
</html>
