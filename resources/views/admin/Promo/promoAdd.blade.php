@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Add Promo</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/promo')}}">Promo</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add Promo</strong>
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
                    <h5>Promo Add <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn "  href="{{url('/produk')}}" title="back">
                           <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- List Input bagian kiri --}}
                            <div class="col-lg-6">
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Code</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        name="code" id="code" placeholder="Input Code Bundling" required>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Judul Bundling</dt> 
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        name="judul" id="judul" placeholder="Nama Bundling" required>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right ">
                                        <dt>Keterangan</dt>
                                    </div>
                                    <textarea class="form-control" name="ket" id="ket"></textarea>
                                </div>
                                &nbsp; 
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right ">
                                        <dt>Item / Produk</dt>
                                    </div>
                                    <input id="item" name="item" placeholder="Pilih item" type="text"
                                        class="form-control form-control-sm-5"> <span class="input-group-append"
                                        data-toggle="modal" data-target="#modal-popup"> <button type="button"
                                            class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                                        </button> </span>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Minimal Beli</dt> 
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="number" min="0" max="9999999" class="form-control"
                                        name="minbeli" id="minbeli" placeholder="Nama Bundling" required>
                                </div>
                                &nbsp; 
                            </div> 
                            {{-- List input Kanan --}} 
                            <div class="col-lg-6">
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Harga</dt> 
                                    </div>
                                    <input style="height: 1.6rem;"  name="harga" id="harga" type="text" class="form-control" aria-label="Harga">
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Tipe Bonus</dt> 
                                    </div>
                                    <select class="form-control" name="tbonus" id="tbonus">
                                        <option></option>
                                        <option value="diskon">Diskon</option>
                                        <option value="free item">Free Item</option>
                                    </select>
                                </div>
                                &nbsp;
                                
                                <div hidden id="diskon" class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Diskon</dt> 
                                    </div>
                                    <input name="diskon" style="height: 1.6rem;"  type="number" name="diskon" id="diskon" class="form-control" aria-label="Diskon">
                                </div>
                                &nbsp;
                                <div hidden id="fitem" class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right ">
                                        <dt>Free Item</dt>
                                    </div>
                                    <input name="fitem" type="text"
                                        class="form-control form-control-sm-5"> <span class="input-group-append"
                                        data-toggle="modal" data-target="#modal-popup"> <button type="button"
                                            class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                                        </button> </span>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Tanggal Awal</dt> 
                                    </div>
                                    <input style="height: 1.6rem;"  type="date" name="awal" id="awal" class="form-control" aria-label="Diskon">
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Tanggal Akhir</dt> 
                                    </div>
                                    <input style="height: 1.6rem;" type="date" name="akhir" id="akhir" class="form-control" aria-label="Berat">
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Stock Bundling</dt> 
                                    </div>
                                    <input style="height: 1.6rem;" type="text" name="stock" id="stock" class="form-control" aria-label="">
                                </div>
                                &nbsp;
                                <h2>Available for</h2>
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Stock Bundling</dt> 
                                    </div>
                                    <input style="height: 1.6rem;" type="radio" name="stock" id="stock" class="form-control" aria-label="">
                                </div>
                                &nbsp;
                            </div> 
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 font-weight-bold col-form-label">Images</label>
                            <div class="col-sm-12">
                               <input name="images" type="file" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white btn-sm" type="reset">Cancel</button>
                                <button class="btn btn-primary btn-sm" type="submit">Save </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Start Pop up data komposisi --}}
<div id="modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog" style="max-width:70%">
        <div class="modal-content">
            <div class="modal-header" >
                <h4 id="exampleModalLabel" class="modal-title"> Detail Data Prodak </h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item"><a href="#Original" class="nav-link show active"
                                    data-from="originalform" role="tab" data-toggle="tab">Original Produk</a></li>
                            
                        </ul>
                    </div>
                </div>

                <div class="tab-content card-body no-padding" style="padding-bottom: 20px !important;">
                    <div id="Original" class="tab-pane active">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable1" style="width: 100%;" class="table table-striped table-hover">
                                        <thead style="background-color:#fff;color:#565151;">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="10%">Code</th>
                                                <th width="45%">Nama Item</th>
                                                <th width="10%">Brand</th>
                                                <th width="10%">Berat</th>
                                                <th width="10%">Unit</th>
                                                <th width="10%">Harga</th>
                                                
                                            </tr>

                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
{{-- End pop up komposisi --}}

1
@endsection
@section('css')
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet"
    href="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/css/buttons.dataTables.min.css')}}">
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

<!-- Mainly scripts -->
<!-- Typehead -->
<script src="{{asset('assets/js/plugins/typehead/bootstrap3-typeahead.min.js')}}"></script>
<script>
   $(document).on("show.bs.modal","#modal-popup",function(){
    var e="";
    $('#datatable1').dataTable().fnClearTable();
    $('#datatable1').dataTable().fnDestroy();
    var e = $("#datatable1").DataTable({
        "processing": true,
		"serverSide": true,
        "ordering": true,

		"order": [[ 0, 'asc' ]],
        "ajax":{
        "url": "{{route('jsonproduk')}}",
        "type": "GET",
        },
        "columnDefs": [
            {
                "targets": [7],
                "visible": false
            }],
        "deferRender": true,
        "aLengthMenu": [[10, 50, 100],[ 10, 50, 100]],
        "responsive": true,

    });

    
    $(document).ready(function () {
            var table = $('#datatable1').DataTable();

            $('#datatable1 tbody').on('click', 'tr', function (e) {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                    var data = $('#datatable1').DataTable().row('.selected').data();

                    $('#modal-popup').modal('hide');
                    $('#item').val(data[1]);
                    $('#harga').val(data[6]);  
                    
                }

            });
        });
});




 // Logic Cek Box

 $( "#tbonus" ).change(function() {
    var jenis= $('#tbonus').val();
            // console.log(jenis);
            if($('#tbonus').val() == "diskon"){
                // console.log("Bahan Baku");
                $('#fitem').attr('hidden', 'hidden');
                $('#diskon').removeAttr('hidden');
            }
            else if($('#tbonus').val() == "free item"){
                // console.log("Produk Utama");
                $('#diskon').attr('hidden', 'hidden');
                $('#fitem').removeAttr('hidden');
                
            }else{
                $('#fitem').attr('hidden', 'hidden');
                $('#diskon').attr('hidden', 'hidden');
            }
});

// Function perhitungan harga
function calprice(e){
    let harga = $('#harga').val();
    let diskon = $('#diskon').val();

    if (diskon > 100) {
        total = harga - diskon; 
    }else{
        total = (harga-(harga*diskon/100));
    }
    $('#totalharga').val(total);

}


// Funtion hapus jomposisi item
function removetable(e){
    let id=e.id;
    $("#tr"+id).remove();
    let subtotal=0;
    let grandtotal=0;
                    $('.totalprice').each(function(index,item){
                        subtotal +=parseFloat(item.value);
                        grandtotal +=parseFloat(item.value);
                    });
                    $("#btotal").val(subtotal);
                    $("#gtotal").val(grandtotal);
}

    $(document).ready(function () {
        $('.typeahead_3').typeahead({
            source: [{
                    "name": "Banten/kota Tangerang/Jatiuwung/Manis Jaya"
                },
                {
                    "name": "Banten/kota Tangerang/Tanah Tinggi/Tanah Tinggi"
                },
            ]
        });
    });
</script>
@stop

