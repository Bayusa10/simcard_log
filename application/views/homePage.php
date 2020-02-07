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

  <!-- DataTables CSS -->
  <link href="<?php echo base_url().'assets/css/addons/datatables.min.css';?>" rel="stylesheet">

</head>
<body>


  <!--Navigation -->
  <?php $this->load->view('navigation'); ?>
  <!--Navigation -->

  <!-- Main Layout -->
  <main>
    <div class="container-fluid" style="padding-top: 20px;">
      
      <div class="row">
        <div class="col-lg-12">
           <h5 class="text-left font-weight mb-4">Beranda</h5>
           <hr>
        </div>
      </div>

      <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <!-- Title -->
              <h2 class="card-title text-center"><b id="u_name"></b></h2>
              <!-- Text -->
              <p class="card-text text-center">Waktu Login</p>
              <p class="text-center"> <b id="login_time"></b> </p>
              <!-- Button -->
              <p class="card-text text-center">IP Login</p>
              <p class="text-center"> <b id="ip_login"></b> </p>
            </div>
          </div>
        </div>
  </main>
  <!-- Main Layout -->

  <!-- jQuery -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'?>"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/popper.min.js'?>"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/mdb.min.js'?>"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/addons/datatables.min.js'?>"></script>
  <!-- Toastr -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/toastr.min.js'?>"></script>
  <!-- Your custom scripts (optional) -->
  <script type="text/javascript">

    // Material Design example
  $(document).ready(function () {

    const counter_    = localStorage.getItem('counter');
    const uname       = localStorage.getItem('userName').toUpperCase();
    const ip_user     = localStorage.getItem('userIP');
    const login_time  = localStorage.getItem('loginTime');

    if(counter_ == null){

      toastr.success("Hii "+uname+", Selamat Datang");

      localStorage.setItem('counter', 'ok');

    }

    $("#u_name").html(uname);
    $('#login_time').html(login_time);
    $('#ip_login').html(ip_user);


    $('#tableSimCard').DataTable({

          "oLanguage": {
              //"sLengthMenu": "Baris Data _MENU_",
              "sSearch"    : "Cari Data"
            },

          "bLengthChange": false,
          "bFilter": true,

          "pagingType": "simple_numbers"

    });


    $('#tableCardRegion').DataTable({

          "oLanguage": {
              //"sLengthMenu": "Baris Data _MENU_",
              "sSearch"    : "Cari Data"
            },

          "bLengthChange": false,
          "bFilter": true,

          "pagingType": "simple_numbers"

    });

    $('#do-logout').click(function(e){

        let userConfirm = confirm('Anda yakin ingin logout?');

        if(userConfirm){

          $.ajax({
            url     : 'doLogout',
            dataType: 'json',  
            success : function(data){

              if(data.response == 200){

                localStorage.clear();
                window.location.href = '<?php echo base_url();?>';

              } else {

                toastr.warning("Ada kesalahan sistem, mohon refresh halaman dan ulangi proses");

              }

            }

          });

          return false;

        } else {

          return true;
        
        }

    });

  });
  </script>

</body>
</html>
