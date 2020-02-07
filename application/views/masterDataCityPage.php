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
              
              <h5 class="text-center font-weight-bold mb-4">Master Data Kota/Kab.</h5>
              <div class="col-lg-12">
                <div class="row">

                  <div class="col-lg-3">
                      <a href="" class="btn btn-primary" data-toggle="modal" data-target="#fileCSVAddRegion"> Tambah Lewat File</a>
                  </div>


                  <div class="col-lg-3">
                      <a href="" class="btn btn-primary" data-toggle="modal" data-target="#AddRegion"> Tambah Manual</a>
                  </div>

                </div>
                
              </div>
              <hr>

              <table id="tableCity" class="table table-striped" cellspacing="0" width="100%">
      
                  <thead style="text-align: center;">
                      <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">Nama Kota/Kab.</th>
                          <th class="th-sm">Provinsi</th>
                          <th class="th-sm">Penginput</th>
                      </tr>
                  </thead>
                  
                  <tbody style="text-align: center;">

                  </tbody>
          
                  <tfoot style="text-align: center;">
                      <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">Nama Kota/Kab.</th>
                          <th class="th-sm">Provinsi</th>
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
          <h4 class="modal-title black-text w-100 font-weight-bold py-2">Pilih File Untuk Tambah Data Kota/Kab.</h4>
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
          <a type="button" class="btn btn-warning" id="closeModalFile">Batal <i class="fas fa-paper-plane-o ml-1"></i></a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
<!-- Modal Upload File -->


  <!-- Modal Tambah Provinsi -->
  <div class="modal fade bd-example-modal-lg" id="AddRegion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header text-center">
          <h4 class="modal-title black-text w-100 font-weight-bold py-2">Tambah Data Kota/Kab.</h4>
        </div>

        <!--Body-->
        <div class="modal-body">
          
          <form id="frmManual">
            
            <div class="md-form mb-5">
              <select class="browser-default custom-select" id="chooseRegion" name="chooseRegion">
              </select>
            </div>

            <div class="md-form mb-5">
              <input type="email" id="cityName" name="cityName" class="form-control">
              <label data-error="wrong" data-success="right" for="orangeForm-email" id="cityLabel">Nama Kota</label>
            </div>

          </form>  

        </div>

        <!--Footer-->
        <div class="modal-footer">
          <a type="button" class="btn btn-primary" id="addManual">Proses <i class="fas fa-paper-plane-o ml-1"></i></a>
          <a type="button" class="btn btn-warning" id="cancelAddManual">Batal <i class="fas fa-paper-plane-o ml-1"></i></a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
<!-- Modal Tambah Provinsi -->

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
    $('#tableCity').DataTable({

          "oLanguage": {
              "sLengthMenu": "Baris Data _MENU_",
              "sSearch"    : "Cari Data"
            },

          "pagingType": "simple_numbers",

          'ajax'      : {"url" : base_url+'UserTransactionController/cityList'},
          "columns"   : [
                          {"data": "Numb"},
                          {"data": "City"},
                          {"data": "Province"},
                          {"data": "UInsert"}
                        ],
          "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]]

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
      
      var idFile  = $("input[name='fileChoosen']:checked").val();

      if(idFile == null){
      
        alert('Anda belum memilih file');
        return false;
      
      } else {

        $.ajax({

          url     : base_url+'addCityBatch',
          method  : 'post',
          data    : {idFile : idFile},
          dataType: 'json',
          cache   : false,
          success : function(response){

                if(response.response == 200){

                  toastr.success('Data Kota/Kabupaten Berhasil Ditambahkan');
                  $('#tableCity').DataTable().ajax.reload(null, false);

                } else if (response.response == 400) {

                  toastr.error('Data Kota/Kabupaten Gagal Ditambahkan, Mohon Ulangi Proses');

                } else if (response.response == 404) {

                  toastr.warning('File Yang Anda Pilih Tidak Memiliki Data Kota/Kabupaten');

                } else {

                  toastr.warning('Semua Data Kota/Kabupaten Didalam File Sudah Pernah Diinputkan');

                }

          },
          error   : function(Status, xhr, err){

                toastr.error('Error Pada Sistem, Ulangi Proses'); 
          }

        });

      }

    });

    $('#closeModalFile').click(function(){
      $('#fileCSVAddRegion').modal('hide');
      $('#formFile').trigger('reset');
    });



    $('#addManual').click(function(){

      var idRegion  = $('#chooseRegion').val();
      var city      = $('#cityName').val();

      if(idRegion == 0 || city == ""){

        alert('Anda belum memilih provinsi atau mengisi nama kota/kabupaten')
        return false;

      } else {

        $.ajax({

          url       : base_url+'addCity',
          data      : {idRegion : idRegion, cityName : city},
          dataType  : 'json',
          method    : 'post',
          success   : function(response){

            if(response.response == 200){

              toastr.success('Data Kota/Kabupaten Berhasil Ditambahkan');
              $('#tableCity').DataTable().ajax.reload(null, false);

            } else {

              toastr.warning('Data Kota/Kabupaten Sudah Pernah Diinputkan');

            }


          },
          error     : function(xhr, Status, err){

             toastr.error('Error Pada Sistem, Ulangi Proses'); 

          }

        });


      }

    });


    $('#cancelAddManual').click(function(){

      $('#AddRegion').modal('hide');
      $('#frmManual').trigger('reset');
      $('#cityLabel').removeClass('active');

    });

    /* Fungsi untuk append pilihan provinsi */
    $.ajax({

      url     : base_url+'getListRegion',
      dataType: 'json',
      success : function(response){

        $('#chooseRegion').append(response);

      }


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
 