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
              
              <h5 class="text-center font-weight-bold mb-4">Master Data SIM Card</h5>
              <div class="col-lg-12">
                <div class="row">

                  <div class="col-lg-4">
                      <a href="" class="btn btn-primary" data-toggle="modal" data-target="#fileCSVAddRegion"> Update Data SIM Card</a>
                  </div>

                  <!--
                  <div class="col-lg-3">
                      <a href="" class="btn btn-primary" data-toggle="modal" data-target="#AddSimNumb"> Tambah Manual</a>
                  </div>-->

                </div>
                
              </div>
              <hr>

              <table id="tableSIMCard" class="table table-striped" cellspacing="0" width="100%">
                
                  <thead style="text-align: center;">
                      <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">RTU ID</th>
                          <th class="th-sm">No. SIM Card</th>
                          <th class="th-sm">Kota/Kab.</th>
                          <th class="th-sm">Provinsi</th>
                          <th class="th-sm">Latest Read</th>
                          <th class="th-sm">Penginput</th>
                      </tr>
                  </thead>
                  
                  <tbody style="text-align: center;">

                  </tbody>
          
                  <tfoot style="text-align: center;">
                      <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">RTU ID</th>
                          <th class="th-sm">No. SIM Card</th>
                          <th class="th-sm">Kota/Kab.</th>
                          <th class="th-sm">Provinsi</th>
                          <th class="th-sm">Latest Read</th>
                          <th class="th-sm">Penginput</th>
                      </tr>
                  </tfoot>

              </table>

            </div>
          </div>
        </div>
      
      </div>

    </div>
  </main>
  <!-- Main Layout -->

  <!-- Modal Upload File -->
  <div class="modal fade bd-example-modal-lg" id="fileCSVAddRegion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header text-center">
          <h4 class="modal-title black-text w-100 font-weight-bold py-2">Pilih File Untuk Update Data SIM Card</h4>
        </div>

        <!--Body-->
        <div class="modal-body">
            
            <form id="formFile">
              <table id="tableFileCSV" class="table table-striped" cellspacing="0" width="100%">  
                <thead style="text-align: center;">
                    <tr>
                        <th class="th-sm">No.</th>
                        <th class="th-sm">Nama File</th>
                        <th class="th-sm">Tanggal Input</th>
                        <th class="th-sm">Penginput</th>
                        <th class="th-sm">Aksi</th>
                    </tr>
                </thead>
                  
                <tbody style="text-align: center;">

                </tbody>
          
                <tfoot style="text-align: center;">
                    <tr>
                        <th class="th-sm">No.</th>
                        <th class="th-sm">Nama File</th>
                        <th class="th-sm">Tanggal Input</th>
                        <th class="th-sm">Penginput</th>
                        <th class="th-sm">Aksi</th>
                    </tr>
                </tfoot>
              </table>
            </form>
        
        </div>

        <!--Footer-->
        <div class="modal-footer">
          <a type="button" class="btn btn-primary" id="addFromFile">Proses <i class="fas fa-paper-plane-o ml-1"></i></a>
          <a type="button" class="btn btn-warning" id="closeAddFromFile">Batal <i class="fas fa-paper-plane-o ml-1"></i></a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
<!-- Modal Upload File -->

<!--
   Modal Tambah Provinsi
  <div class="modal fade bd-example-modal-lg" id="AddSimNumb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      Content
      <div class="modal-content">
       Header
        <div class="modal-header text-center">
          <h4 class="modal-title black-text w-100 font-weight-bold py-2">Tambah Data SIM Card</h4>
        </div>

        Body
        <div class="modal-body">
          <form id="frmManual">
          
            <div class="md-form mb-5">
              <select class="browser-default custom-select" id="chooseRegion" name="chooseRegion">
              </select>
            </div>


            <div class="md-form mb-5">
              <select class="browser-default custom-select" id="chooseCity" name="chooseCity">
              </select>
            </div>

            <div class="md-form mb-5">
              <input type="email" class="form-control" id="simNumb" name="simNumb">
              <label data-error="wrong" data-success="right" for="orangeForm-email" id="simcardLabel">No. SIM Card</label>
            </div>
          
          </form>
        </div>

        Footer
        <div class="modal-footer">
          <a type="button" class="btn btn-primary" id="addManual">Proses <i class="fas fa-paper-plane-o ml-1"></i></a>
          <a type="button" class="btn btn-warning" id="cancelAddManual">Batal <i class="fas fa-paper-plane-o ml-1"></i></a>
        </div>
      </div>
      /.Content
    </div>
  </div>
Modal Tambah Provinsi -->


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
    
  const base_url = '<?php echo base_url();?>';
    // Material Design example
  $(document).ready(function () {
    $('#tableSIMCard').DataTable({

          "oLanguage": {
              "sLengthMenu": "Baris Data _MENU_",
              "sSearch"    : "Cari Data"
            },

          'ajax'      : base_url+'UserTransactionController/listSIMCard/0', 
          'columns'   : [
                          {"data" : "Numb"},
                          {"data" : "RTU ID"},
                          {"data" : "SIM Number"},
                          {"data" : "City"},
                          {"data" : "Region"},
                          {"data" : "Latest Read"},
                          {"data" : "User Insert"}
                        ], 
          "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],
          "pagingType": "simple_numbers"

    });

    $('#tableFileCSV').DataTable({

          "oLanguage": {
              "sLengthMenu": "Baris Data _MENU_",
              "sSearch"    : "Cari Data"
            },

          "pagingType": "simple_numbers",
          "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],

          'ajax'      : {"url" : base_url+'UserTransactionController/listLogFile/1'},
          "columns"   : [
                          {"data": "Numb"},
                          {"data": "File Name"},
                          {"data": "Date Upload"},
                          {"data": "Uploader"},
                          {"data": "Action"}
                        ]

    });

    $('#addFromFile').click(function(){
      
      var idFile = $("input[name='fileChoosen']:checked").val();

      if(idFile == null){

        alert('Anda belum memilih file');
        return false;

      } else {

        $.ajax({

          url     : base_url+'addSCardBatch',
          data    : {idFile : idFile},
          dataType: 'json',
          method  : 'post',
          cache   : false,
          success : function(response){

                if(response.response == 200){

                  toastr.success('Data Simcard Berhasil Diupdate');
                  $('#tableSIMCard').DataTable().ajax.reload(null, false);

                } else if (response.response == 400) {

                  toastr.error('Data Simcard Gagal Ditambahkan, Mohon Ulangi Proses');

                } else if (response.response == 404) {

                  toastr.warning('File Yang Anda Pilih Tidak Memiliki Data Simcard');

                } else {

                  toastr.warning('Semua Data Simcard Sudah Pernah Diupdate');

                }

          },
          error   : function(Status, xhr, err){

                toastr.error('Error Pada Sistem, Ulangi Proses'); 
          }



        });


      }

    });

    $('#closeAddFromFile').click(function(){

      $('#fileCSVAddRegion').modal('hide');
      $('#formFile').trigger('reset');

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

    /* Fungsi untuk append pilihan provinsi 
    $('#addManual').click(function(){
      
      var idRegion    = $('#chooseRegion').val();
      var idCity      = $('#chooseCity').val();
      var simcardNumb = $('#simNumb').val();

      if(idRegion == 0 || idCity == 0 || simcardNumb == ''){
        
        toastr.warning('Data tidak lengkap');
        return false;
      
      } else {
          
      }

    });

    $('#cancelAddManual').click(function(){
      $('#AddSimNumb').modal('hide');
      $('#frmManual').trigger('reset');
      $('#chooseCity').empty();
      $('#simcardLabel').removeClass('active');
    });

    $.ajax({

      url     : base_url+'getListRegion',
      dataType: 'json',
      success : function(response){

        $('#chooseRegion').append(response);

      }

    });

    $('#chooseRegion').change(function(){
      
      var regionID = $('#chooseRegion').val();

      if(regionID != 0){

        $.ajax({

          url     : base_url+'UserTransactionController/getCity',
          data    : {idRegion : regionID},
          method  : 'post',
          dataType: 'json',
          success : function(response){

            $('#chooseCity').empty()
                            .append(response);

          }

        });
      } 

    });*/

  });
  </script>

</body>
</html>
