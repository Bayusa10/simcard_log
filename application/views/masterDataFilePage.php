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
              
              <h5 class="text-center font-weight-bold mb-4">Master Data File XLS/XLSX</h5>
              <div class="col-lg-12">
                <div class="row">

                  <div class="col-lg-3">
                      <a href="" class="btn btn-primary" data-toggle="modal" data-target="#fileLogDataUploadModal"> Upload File</a>
                  </div>

                </div>
                
              </div>
              <hr>

              <table id="tablefileLogData" class="table table-striped" cellspacing="0" width="100%">
      
                  <thead style="text-align: center;">
                      <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">Nama File</th>
                          <th class="th-sm">Tgl Upload</th>
                          <th class="th-sm">Uploader</th>
                          <th class="th-sm">Up to DB</th>
                          <th class="th-sm">Tgl Upload DB</th>
                      </tr>
                  </thead>
                  
                  <tbody style="text-align: center;">

                  </tbody>
          
                  <tfoot style="text-align: center;">
                    <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">Nama File</th>
                          <th class="th-sm">Tgl Upload</th>
                          <th class="th-sm">Uploader</th>
                          <th class="th-sm">Up to DB</th>
                          <th class="th-sm">Tgl Upload DB</th>
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
  <div class="modal fade" id="fileLogDataUploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
    <div class="modal-dialog modal-notify modal-primary" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header text-center">
          <h4 class="modal-title white-text w-100 font-weight-bold py-2">Upload File</h4>
        </div>

        <form id="frm-upl">
      
          <!--Body-->
          <div class="modal-body">
            <div class="md-form mb-5">
              <input type="text" id="fileName" name="fileName" class="form-control validate" onkeyup="this.value = this.value.toUpperCase();">
              <label data-error="wrong" data-success="right" for="form3">Nama File</label>
            </div>

            <div class="md-form">
              <div class="custom-file">
                <input type="file" id="fileLogData" name="fileLogData" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" onchange="CheckExtension(this);">
                <label class="custom-file-label" for="inputGroupFile01">Pilih File</label>
              </div>
            </div>
          </div>
         
          <!--Footer-->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="uploadFile">Proses <i class="fas fa-paper-plane-o ml-1"></i></a>
            <button type="button" class="btn btn-warning" id="modalDismiss">Batal <i class="fas fa-paper-plane-o ml-1"></i></a>
          </div>
        <!--/.Content-->

      </form>
    </div>
  </div>
<!-- Modal Upload File -->


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

  var isAllowedFile = false;
  var base_url      = '<?php echo base_url();?>';

    // Material Design example
  $(document).ready(function () {
    $('#tablefileLogData').DataTable({

          "oLanguage" : {
              "sLengthMenu": "Baris Data _MENU_",
              "sSearch"    : "Cari Data"
            },

          "pagingType": "simple_numbers",

          'ajax'      : {"url" : base_url+'UserTransactionController/listLogFile/0'},
          "columns"   : [
                          {"data": "Numb"},
                          {"data": "File Name"},
                          {"data": "Date Upload"},
                          {"data": "Uploader"},
                          {"data": "Up to DB"},
                          {"data": "Date Up DB"}
                        ]

    });

    $('#frm-upl').submit(function(e){
      e.preventDefault();
      var fname   = $.trim($('#fileName').val());
      var file_   = $.trim($('#fileLogData').val());

      var checkForm = CheckForm(fname, file_);

      if(checkForm){

        if(isAllowedFile){
          
          $.ajax({
            url         : base_url+'uploadFile',
            data        : new FormData(this),
            dataType    : 'json',
            method      : 'post',
            processData : false,
            contentType : false,
            cache       : false,
            async       : false,
            success   : function(response){

              if(response.response == 200){

                $('#fileLogDataUploadModal').modal('hide');
                $('#frm-upl').trigger('reset');
                
                setTimeout(function(){
                  toastr.success('File berhasil diupload');
                }, 500);

                $('#tablefileLogData').DataTable().ajax.reload(null, false);

              } else {

                $('#fileLogDataUploadModal').modal('hide');
                $('#frm-upl').trigger('reset');
                
                setTimeout(function(){
                  toastr.warning('Ada kesalahan, mohon ulangi proses');
                }, 500);

                $('#tablefileLogData').DataTable().ajax.reload(null, false);
              }

            },
            error     : function(err, Status, xhr){

                $('#fileLogDataUploadModal').modal('hide');
                $('#frm-upl').trigger('reset');
                
                setTimeout(function(){
                  toastr.warning('Ada kesalahan sistem, mohon ulangi proses'); 
                }, 500);             

                $('#tablefileLogData').DataTable().ajax.reload(null, false);
            }

          });

          return false;

        } else {

          toastr.warning('Extension file yang diijinkan hanya .XLS atau XLSX');

        }

      } else {

        toastr.warning('Form inputan masih ada yang kosong');

      }

    });

    $('#modalDismiss').click(function(e){
      e.preventDefault();

      $('#fileLogDataUploadModal').modal('hide');
      $('#frm-upl').trigger('reset');

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

  function CheckExtension(file){

    var fileName = file.value;
    var file_ext = fileName.split('.');

    if(file_ext[1] == 'xls' || file_ext[1] == 'XLS' || file_ext[1] == 'xlsx' || file_ext[1] == 'XLSX' ){

      isAllowedFile = true;

    } else {

      isAllowedFile = false;

    }

    return isAllowedFile;

  }

  function CheckForm(fname, file){

    if (fname === '' || file === '') {

      return false;

    } else {

      return true;

    }


  }

  </script>

</body>
</html>
