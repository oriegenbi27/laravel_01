@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tables Outlet</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Outlet List  </strong>

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
                    <h5>Data Outlet  </h5>
                </div>
                <div class="ibox-tools">
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                    <form id="privilageform" action="" method="post">
                      @csrf
                      {!! $html->table() !!}
                    </form>
                    </div>
                </div>
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
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/fixedHeader.dataTables.min.css')}}">
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
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.fixedHeader.min.js')}}"></script>
<!-- Sweet alert -->
<script src="{{asset('assets/js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
   function hapus(id){


     console.log(id);
      swal({
          title: "Are you sure?",
          text: "Your will not be able to recover this ",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!",
          },
      function (isConfirm) {
          if (isConfirm) {
              $.ajax({
                'url' : '{{route("Delete Outlet")}}',
                'method': 'POST',
                'dataType': 'Json',
                'data':{
                  '_token': '{{ csrf_token() }}',
                  'id':id,
                },
                'success':function(data , response){
                  console.log(data.code)
                  if(data.code==0){
                    swal("Deleted", data.message, "success");                  
                  $('#dataTableBuilder').DataTable().ajax.reload();
                  }else{
                    swal("warning", data.message, "warning");                  
                  }

                },
              });

          }else{
              swal("Cancelled", "Your imaginary file is safe :)", "error");
              return false;
          }
      });
    }
</script>
<!-- Mainly scripts -->
{!! $html->scripts() !!}
<script>
function showmodalprivilege(){
    $.get("{{route('Erp Privilage')}}",function(e){
                $(".modal-title").text(e.title);
                $(".modal-body").html(e.html);
                $("#ModalErp").modal('show');
		});
}
var privilagepost=0;

function changeprivilage(e){
 let id=e.id;
    privilagepost=$("#"+id).data('id');

    $("#privilagetext").text('');
    $("#privilagetext").text($("#"+id).data('text'));

    if(chekcountUsPrivilage()){
        $("#privilageform").submit();
    }else{
        alert('pilih dulu');
    }
}
$(document).on("submit", "#privilageform", function (e) { 
	e.preventDefault();
	Hxr(this);
});	

function Hxr(data){
    let formData = new FormData(data);
        formData.append("flag",privilagepost );
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} });
    $.ajax({
        type: 'POST',
        url:"{{route('Erp Karyawan')}}",
        data: formData,
        processData: false,
        contentType: false,	
        success: function(e) {
            alert(e.message);
            $('#dataTableBuilder').DataTable().ajax.reload();
            $("#ModalErp").modal('hide');
            }
    });        
}

function chekcountUsPrivilage(){
    let chekoption=0;

    $('.chekprivilagelist').each(function(){
        if($(this).is(":checked")) {
                chekoption ++;
            }
    });
    if(chekoption==0){ return false;}else{return true;}

}

</script>
@stop