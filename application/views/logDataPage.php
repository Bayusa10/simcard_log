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
           <h5 class="text-left font-weight mb-4">Log Data</h5>
           <hr>
        </div>
      </div>

      <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              
              <h5 class="text-center font-weight-bold mb-4">Log Data SIM Card</h5>

                <div class="row">
                  <div class="col-lg-10">
                  </div>
                  <div class="col-lg-2 flex-center">
                    <a type="button" class="btn btn-success col-lg-12" data-toggle="modal" data-target="#dataLogWithRange">Export Excel</a> 
                  </div>  
                </div>
              
              <hr>

              <table id="tableSIMCard" class="table table-striped" cellspacing="0" width="100%">
      
                  <thead style="text-align: center;">
                      <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">Nomor Kartu</th>
                          <th class="th-sm">Kota/Kab.</th>
                          <th class="th-sm">Provinsi</th>
                          <th class="th-sm">Latest Read</th>
                          <th class="th-sm">Aksi</th>
                      </tr>
                  </thead>
                  
                  <tbody style="text-align: center;">

                  </tbody>
          
                  <tfoot style="text-align: center;">
                      <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">Nomor Kartu</th>
                          <th class="th-sm">Kota/Kab.</th>
                          <th class="th-sm">Provinsi</th>
                          <th class="th-sm">Latest Read</th>
                          <th class="th-sm">Aksi</th>
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

<!--Modal: modalConfirmDelete-->
  <div class="modal fade" id="dataLogWithRange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-success" role="document">
      <!--Content-->
      <div class="modal-content text-center">
        <!--Header-->
        <div class="modal-header d-flex justify-content-center">
          <p class="heading">Cetak Log Ke Excel</p>
        </div>

        <!--Body-->
        <div class="modal-body">
          <div class="md-form mb-5">
            <input type="text" id="fName" name="fName" class="form-control" placeholder="Masukkan Nama File">
          </div>
        </div>

        <!--Footer-->
        <div class="modal-footer flex-center">
          <a type="button" class="btn  btn-primary" id="exportExcel">Proses</a>
          <a type="button" class="btn  btn-danger" data-dismiss="modal">Batal</a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
<!--Modal: modalConfirmDelete-->
  

  <!-- Modal Upload File -->
  <div class="modal fade bd-example-modal-lg" id="detailLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header text-center">
          <h4 class="modal-title black-text w-100 font-weight-bold py-2" id="headerLabel"></h4>
        </div>

        <!--Body-->
        <div class="modal-body">

            <table id="tableDetailLog" class="table table-striped" cellspacing="0" width="100%">
      
                  <thead style="text-align: center;">
                      <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">RTU ID</th>
                          <th class="th-sm">Kota/Kab.</th>
                          <th class="th-sm">Provinsi</th>
                          <th class="th-sm">Tanggal SMS</th>
                          <th class="th-sm">Isi SMS</th>
                      </tr>
                  </thead>
                  
                  <tbody style="text-align: center;">

                  </tbody>
          
                  <tfoot style="text-align: center;">
                      <tr>
                          <th class="th-sm">No.</th>
                          <th class="th-sm">RTU ID</th>
                          <th class="th-sm">Kota/Kab.</th>
                          <th class="th-sm">Provinsi</th>
                          <th class="th-sm">Tanggal SMS</th>
                          <th class="th-sm">Isi SMS</th>
                      </tr>
                  </tfoot>

            </table>

        </div>

        <!--Footer-->
        <div class="modal-footer">
          <a type="button" class="btn btn-warning" id="closeModalDetailLog">Tutup<i class="fas fa-paper-plane-o ml-1"></i></a>
        </div>
      </div>
      <!--/.Content-->
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
  <!-- Your custom scripts (optional) -->
  <script type="text/javascript">
    
  // Material Design example
  const base_url = '<?php echo base_url();?>';

  $(document).ready(function () {

    var tabelLog =  $('#tableDetailLog').DataTable({
                          "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]]
                    });
     
    $('#tableSIMCard').DataTable({

          "oLanguage": {
              "sLengthMenu": "Baris Data _MENU_",
              "sSearch"    : "Cari Data"
            },

          'ajax'      : base_url+'UserTransactionController/listSIMCard/1', 
          'columns'   : [
                          {"data" : "Numb"},
                          {"data" : "SIM Number"},
                          {"data" : "City"},
                          {"data" : "Region"},
                          {"data" : "Latest Read"},
                          {"data" : "Action"}
                        ], 

          "pagingType": "simple_numbers",
          "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]]

    });

    //$('#detailLog').modal('show');

    $('#tableSIMCard').on('click','#scardChoosen', function(){

      var idSCard = $(this).data('id');

      $.ajax({

        url     : base_url+'UserTransactionController/logDataSCard',
        data    : {idScard : idSCard},
        dataType: 'json',
        method  : 'post',
        success : function(response){

            tabelLog.clear().draw();

            if (response['data'].length > 0) {

              var idx = 0;

              for(idx; idx < response['data'].length; idx++){

                  tabelLog.row.add([
                                response['data'][idx].Numb,
                                response['data'][idx].RTU_ID,
                                response['data'][idx].CITY,
                                response['data'][idx].REGION,
                                response['data'][idx].SMS_DATE,
                                response['data'][idx].SMS_CONTENT
                            ]).draw(false);

              }

              $('#headerLabel').html("Detail Log SIM Card Nomor "+response['simcardNumb']);
              $('#detailLog').modal('show');              

            } else {

              $('#detailLog').modal('show');

            }
        }

      });

    });

    $('#closeModalDetailLog').click(function(){

      tabelLog.clear().draw();
      $('#detailLog').modal('hide');

    });

    $('#exportExcel').click(function(){

      var fileName = $('#fName').val();

      if(fileName == ""){

        alert("Mohon masukkan nama file");
        return false;

      } else {

        $.ajax({

          url     : base_url+'UserTransactionController/ExportExcel',
          data    : {fileName : fileName},
          method  : 'post',
          dataType: 'json',
          success : function(response){

            window.open(base_url+response.link_);

            $('#fName').val('');
            $('#dataLogWithRange').modal('hide');


          }

        });

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
