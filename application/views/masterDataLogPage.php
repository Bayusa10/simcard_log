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
           <h5 class="text-left font-weight mb-4">Master Data</h5>
           <hr>
        </div>
      </div>

      <div class="row">

        <div class="col-lg-3">
          <div class="card">
            <div class="card-body">
                <!--Navigation -->
                  <?php $this->load->view('sideNavigation'); ?>
              <!--Navigation -->
            </div>
          </div>
        </div>

        <div class="col-lg-9">
          <div class="card">
            <div class="card-body">
              
              <h5 class="text-center font-weight-bold mb-4">Data Log SIM Card</h5>
              <div class="col-lg-12">
                <div class="row">

                  <div class="col-lg-4">
                      <a href="" class="btn btn-warning" data-toggle="modal" data-target="#clearDB"><font color="black"> Bersihkan Database</font></a>
                  </div>

                  <div class="col-lg-3" style="margin-left: -80px;">
                      <a href="" class="btn btn-primary" data-toggle="modal" id="procFile"> Upload Data Log </a>
                  </div>

                </div>
                
              </div>
              <hr>

              <form id="listFile">
                <table id="tableFileCSV" class="table table-striped" cellspacing="0" width="100%">
        
                    <thead style="text-align: center;">
                        <tr>
                            <th class="th-sm">No.</th>
                            <th class="th-sm">Nama File</th>
                            <th class="th-sm">Tanggal Upload DB</th>
                            <th class="th-sm">Upload DB</th>
                            <th class="th-sm">Pilih Data</th>
                        </tr>
                    </thead>
                    
                    <tbody style="text-align: center;">

                    </tbody>
            
                    <tfoot style="text-align: center;">
                        <tr>
                            <th class="th-sm">No.</th>
                            <th class="th-sm">Nama File</th>
                            <th class="th-sm">Tanggal Upload DB</th>
                            <th class="th-sm">Upload DB</th>
                            <th class="th-sm">Pilih Data</th>
                        </tr>
                    </tfoot>

                </table>
              </form>

            </div>
          </div>
        </div>
      
      </div>

    </div>
  </main>
  <!-- Main Layout -->

  <!--Modal: modalConfirmDelete-->
  <div class="modal fade" id="clearDB" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
      <!--Content-->
      <div class="modal-content text-center">
        <!--Header-->
        <div class="modal-header d-flex justify-content-center">
          <p class="heading">Anda yakin ingin mengosongkan database log SIM card?</p>
        </div>

        <!--Body-->
        <div class="modal-body">

          <i class="fas fa-times fa-4x animated rotateIn"></i>

        </div>

        <!--Footer-->
        <div class="modal-footer flex-center">
          <a type="button" class="btn  btn-danger" id="clearDBSCard">Ya</a>
          <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">Tidak</a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
<!--Modal: modalConfirmDelete-->


  <!--Modal: modalConfirmUploadLogData-->
  <div class="modal fade" id="uploadLogData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-notify modal-info" role="document">
      <!--Content-->
      <div class="modal-content text-center">
        <!--Header-->
        <div class="modal-header d-flex justify-content-center">
          <p class="heading">Anda yakin ingin upload log data simcard lewat file ini?</p>
        </div>

        <!--Body-->
        <div class="modal-body">

          <p><b>Nama file</b></p>
          <p id="fname"></p>

          <p id="waitLabel" style="visibility: hidden;"><b>Mohon Tunggu ...</b></p>
          <p id="fname"></p>

        </div>

        <!--Footer-->
        <div class="modal-footer flex-center">
          <a type="button" class="btn  btn-primary" id="uploadData">Ya</a>
          <a type="button" class="btn  btn-warning waves-effect" id="cancelUploadData">Tidak</a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
<!--Modal: modalConfirmUploadLogData-->


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
  const base_url = '<?php echo base_url();?>';

  $(document).ready(function () {
    $('#tableFileCSV').DataTable({

          "oLanguage": {
              "sLengthMenu": "Baris Data _MENU_",
              "sSearch"    : "Cari Data"
            },

          'ajax'      : {"url" : base_url+'UserTransactionController/listLogFile/2'},
          "columns"   : [
                          {"data": "Numb"},
                          {"data": "File Name"},
                          {"data": "Date Upload"},
                          {"data": "Up to DB"},
                          {"data": "Action"}
                        ],

          "pagingType": "simple_numbers",
          "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]]

    });

    $('#clearDBSCard').click(function(){
        
      $.ajax({

        url     : base_url+'emptyLogSCard',
        dataType: 'json',
        success : function(response){

          if(response.response == 200){

            toastr.success('Database Log Simcard Berhasil Dikosongkan');
            $('#clearDB').modal('hide');

          } else {

            toastr.success('Database Log Simcard Gagal Dikosongkan');

          }

        },
        error    : function(xhr, Status, err){

             toastr.error('Error Pada Sistem, Ulangi Proses'); 

          }
      });

    });


    $('#procFile').click(function(){

      var idFile = $("input[name='fileChoosen']:checked").val();

      if(idFile == null){

        alert('Anda belum memilih file');
        return false;

      } else {

        $.ajax({

          url     : base_url+'UserTransactionController/getFileName',
          data    : {idFile : idFile},
          dataType: 'json',
          method  : 'post',
          success : function(response){

            $('#fname').html(response.response);
            $('#uploadLogData').modal('show');

          }

        });

      }

    });


    $('#uploadData').click(function(){

      var idFile = $("input[name='fileChoosen']:checked").val();

      $('#waitLabel').css('visibility','visible');

      $.ajax({

        url     : base_url+'uploadLogData',
        data    : {idFile : idFile},
        method  : 'post',
        dataType: 'json',
        success : function(response){

              if(response.response == 200){
                  if(response.simcard_not_found == true){

                    /**/
                    $.ajax({

                        url     : base_url+'UserTransactionController/insertLogSCardNF',
                        data    : {idFile : idFile},
                        method  : 'post',
                        dataType: 'json',
                        success : function(response){

                            if(response.response == 200){

                              $('#uploadLogData').modal('hide');
                              $('#waitLabel').css('visibility','hidden');

                              toastr.success('Data Log SIM Card Berhasil Ditambahkan, Silahkan Menuju Menu Log SIM Card Untuk Melihat Log Data');
                              
                              $('#tableFileCSV').DataTable().ajax.reload(null, false);


                            } else {

                              $('#uploadLogData').modal('hide');
                              $('#waitLabel').css('visibility','hidden');

                              toastr.warning('File Yang Anda Pilih Tidak Memiliki Data Log SIM Card');  

                            }

                        },
                        error   : function(Status, xhr, err){

                                $('#uploadLogData').modal('hide');
                                $('#waitLabel').css('visibility','hidden');

                                toastr.error('Error Pada Sistem, Ulangi Proses'); 
                        }

                    });


                  } else {

                      $('#uploadLogData').modal('hide');
                      $('#waitLabel').css('visibility','hidden');

                      toastr.success('Data Log SIM Card Berhasil Ditambahkan, Silahkan Menuju Menu Log SIM Card Untuk Melihat Log Data');
                              
                      $('#tableFileCSV').DataTable().ajax.reload(null, false);
                  
                  }

              } else if (response.response == 400) {

                $('#uploadLogData').modal('hide');
                $('#waitLabel').css('visibility','hidden');

                toastr.error('Data Log SIM Card Gagal Ditambahkan, Mohon Ulangi Proses');

              } else if(response.response == 204){

                $('#uploadLogData').modal('hide');
                $('#waitLabel').css('visibility','hidden');

                toastr.warning('Log Yang Lama Masih Tersimpan, Mohon Bersihkan Terlebih Dahulu');

              } else {

                $('#uploadLogData').modal('hide');
                $('#waitLabel').css('visibility','hidden');

                toastr.warning('File Yang Anda Pilih Tidak Memiliki Data Log SIM Card');

              } 

        },
        error   : function(Status, xhr, err){

                $('#uploadLogData').modal('hide');
                $('#waitLabel').css('visibility','hidden');

                toastr.error('Error Pada Sistem, Ulangi Proses'); 
        }
        
      });

    });


    $('#cancelUploadData').click(function(){

      $('#listFile').trigger('reset');
      $('#uploadLogData').modal('hide');

    });

    $('#do-logout').click(function(e){

        let userConfirm = confirm('Anda yakin ingin logout?');

        if(userConfirm){

          $.ajax({
            url     : base_url+'doLogout',
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
