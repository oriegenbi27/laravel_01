@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tables Jabtan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Jabtan List </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Data Jabtan</h5>
                </div>
                <div class="ibox-tools">

                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="text-center table table-striped table-bordered table-hover data-karywan" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jabatan</th>
                                    <th>Menu Akses</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                 $no = 1
                                 ?>
                                @foreach($jabatan->data as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$row->nama}}</td>
                                    <td><a href="{{route('Hak Akses' , $row->id)}}" class="btn btn-primary"><span class="text-white">Edit Hak Akses Jabatan</span></a></td>
                                    <td class="text-center">
                                        <a class="btn btn-primary" onclick="return edit({{$row->id}} , '{{$row->nama}}')"  href="#"><i class="fa fa-pencil" title="EDIT"></i></a> &nbsp; &nbsp;
                                        &nbsp;
                                        <a class="btn btn-danger" onclick="return hapus({{$row->id}})"><i class="fa fa-trash text-white" title="DELETE"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="jabatanmodal" tabindex="-1" role="dialog" aria-labelledby="posModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="posModalLabel">Input Jabatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
         <form action="#" id="AddJabatan" method="Post">
          <div class="form-group">
            <label class="form-label" for="">Jabatan : </label>
            <input type="text" id="jabtan-input" class="form-control" placeholder="jabatan" required>
          </div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" id="savejabatan" class="btn btn-primary">Save Jabatan</button> -->
      </div>
    </div>
  </div>
</div>
@endsection
@section('css')
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/css/buttons.dataTables.min.css')}}">
<!-- Sweet Alert -->
<link href="{{asset('assets/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
@stop
@section('js')
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/tables-datatable.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/fnReloadAjax.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/buttons.print.min.js')}}"></script>

<!-- Sweet alert -->
<script src="{{asset('assets/js/plugins/sweetalert/sweetalert.min.js')}}"></script>

<!-- Mainly scripts -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.data-karywan').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgtip',
            buttons: [{
                    className: 'btn-primary btn-sm ladda-button',
                    titleAttr: 'Add Data',
                    text: '<i class="fa fa-plus" aria-hidden="true"></i>',
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button');
                    },
                    action: function (e, dt, node, config) {
                      $('.modal-footer').html(
                        '<button type="button" id="savejabatan" class="btn btn-primary">Save Jabatan</button>'
                      )
                      $('#jabatanmodal').modal();
                      $('#jabtan-input').val('');
                      
                    }
                },
                {
                    extend: 'copy',
                    className: 'btn-primary btn-sm ladda-button',
                    titleAttr: 'Copy Data',
                    text: '<i class="fa fa-clone" aria-hidden="true"></i>',
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button')
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-primary btn-sm ladda-button',
                    titleAttr: 'Save To CSV',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button')
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-primary btn-sm ladda-button',
                    titleAttr: 'Print Data',
                    text: '<i class="fa fa-print" aria-hidden="true"></i>',
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button')
                    }
                },

            ],

        });
    });

    $('#savejabatan').on('click' , function(e){
      var jabatan = $('#jabtan-input').val();
      let len     = jabatan.length;
      if(len == 0){   
        swal({
          title: "Periksa Kembali Inputan Anda",
          text: "You clicked the button!",
          type: "error"
         });
      }else{
        console.log(save(jabatan));
        swal({
          title: "Berhasil Tambah Data",
          text: "You clicked the button!",
          type: "success"
        });
      }
     
    })
    function edit(id , nama ){
      $('#jabtan-input').val(nama);
      $('#jabatan-id').val(id);
      $('.modal-footer').html(
        '<button type="button" id="editjabatan" class="btn btn-primary">Edit Jabatan</button>'
      );
      $('#jabatanmodal').modal();

      $('#editjabatan').on('click', function(){
        var jabatan = $('#jabtan-input').val();
        let len     = jabatan.length;
        if(len == 0){   
          swal({
            title: "Periksa Kembali Inputan Anda",
            text: "You clicked the button!",
            type: "error"
          });
        }else{
          console.log(save(jabatan , id));
          swal({
            title: "Berhasil Tambah / Edit Data",
            text: "You clicked the button!",
            type: "success"
          },
            function(){
              location.reload();
            }
          );
        }
      });
      
    }

    function save(jabatan , id){
      var formdata = '';
      var url = '';
      if(!id){
          url = '{{route("Add Jabatan")}}';
          formdata = {
            '_token': '{{ csrf_token() }}',
            'jabatan':jabatan,
          };
        }else{
          url = '{{route("Edit Jabatan")}}';
          formdata = {
            '_token': '{{ csrf_token() }}',
            'id':id,
            'jabatan':jabatan,
          };
        }
        $.ajax({
          'url': url,
          'method':'POST',
          'dataType':'Json',
          'data': formdata,
          'success':function(data , response){
           
            console.log('success' , data , response);
          },
          'error':function(data , response){
            console.log('error' , data , response);
          }
        })
    }

    function hapus(id){
      swal({
          title: "Are you sure?",
          text: "Your will not be able to recover this ",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!",
          closeOnConfirm: false,
          closeOnCancel: false },
      function (isConfirm) {
          if (isConfirm) {
              $.ajax({
                'url' : '{{route("Delete Jabatan")}}',
                'method': 'POST',
                'dataType': 'Json',
                'data':{
                  '_token': '{{ csrf_token() }}',
                  'id':id,
                },
                'success':function(data , response){
                  // console.log('soccess')
                  swal("Deleted!", "Your imaginary file has been deleted.", "success");                  
                  location.reload();
                },
              });

          }else{
              swal("Cancelled", "Your imaginary file is safe :)", "error");
          }
      });
    }
</script>
@stop