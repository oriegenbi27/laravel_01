@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Data Karyawan</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                    <form id="privilageform" action="" method="post">
                    @csrf
                      {!! $html->table() !!}
                    </from>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="ModalErp" tabindex="-1"  role="dialog" aria-labelledby="LabelErpModal" aria-hidden="true" class="modal fade text-left" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <h4 id="LabelErpModal" class="modal-title"> Modal Title</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                
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
        url:"{{route('Erp Customer')}}",
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