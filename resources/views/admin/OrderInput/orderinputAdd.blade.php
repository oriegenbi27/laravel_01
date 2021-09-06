@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Order Input</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/order_input')}}">Order Input</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Order Input</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox border">
                <div class="ibox-title">
                    <h5>Order Input <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{url('/order_input')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- List Input bagian kiri --}}
                            <div class="col-lg-6">
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Sumber Sales</dt>
                                    </div>
                                    <select style="height: 2.2rem;" class="form-control" name="sumber_sales">
                                        <option></option>
                                        @foreach ($sumber->data as $row )
                                        <option value="{{$row->nama}}">{{$row->nama}}</option>
                                        @endforeach
                                       
                                    </select>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Nomer Telepon</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="number" class="form-control"
                                        name="no_tlp" required>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Nama Customer</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        name="nama" required>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Provinsi</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        name="prov" required>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Kabupaten</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        name="kab" required>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Kecamatan</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        name="kec" required>
                                </div>
                                &nbsp;
                            </div>
                            {{-- List input Kanan --}}
                            <div class="col-lg-6">
                                <div class="input-group has-success col-sm-10">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Alamat Lengkap</dt>
                                    </div>
                                    <textarea class="form-control" name="addr" id="" cols="10" rows="5"></textarea>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-10">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Kode Pos</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="number" class="form-control"
                                        name="kode_pos" required>

                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-10">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Type Pembayaran</dt>
                                    </div>
                                    <select class="select2_demo_3 form-control" name="pembayaran">
                                        <option></option>
                                        <option value="Bayar via marketplace">Bayar via marketplace</option>
                                        <option value="Transfer Bni">Transfer Bni</option>
                                        <option value="Transfer Bca">Transfer Bca</option>
                                    </select>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-10">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Keterangan Pembayaran</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        name="ket_pembayaran" required>
                                </div>
                                &nbsp;
                            </div>
                        </div>
                        {{-- Detail Barang --}}

                        {{-- <div class="form-group row"> --}}
                        <div class="col-lg-12">
                            <h3 class="h4">Detail Item Barang</h3>
                            {{-- <div class="card-body"> --}}
                            <div class="form-group">
                                <div class="input-group">
                                    <input disabled="" type="text" id="inputserch" class="form-control"
                                        placeholder="Tambah Data Barang">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modal-popup"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <style>

                            </style>
                            <div class="table-responsivemobile">
                                <table class="tablemobile" id="tablelistproduk" style="font-size:14px">
                                    <thead style="background-color:#fff;color:#565151;" class="theadmobile">
                                        <tr class="trmobile">
                                            <th class="thmobile" width="10%">Code</th>
                                            <th class="thmobile" width="30%">Nama Barang / Berat</th>
                                            <th class="thmobile" width="10%">Price</th>
                                            <th class="thmobile" width="10%">Qty</th>
                                            <th class="thmobile" width="10%">[% atau nominal]</th>
                                            <th class="thmobile" width="10%">Total Price</th>
                                            <th class="thmobile" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="barangdetail" class="tbodymobile">
                                    </tbody>
                                </table>
                            </div>
                            {{-- </div> --}}
                        </div>
                        {{-- </div> --}}
                        {{-- End Detail Barang --}}
                        &nbsp;&nbsp;
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Sub total</dt>
                                    </div>
                                    <input style="height: 1.6rem; background-color: transparent;" autocomplete="off"
                                        id="btotal" type="number" class="form-control" value="0" name="btotal" required
                                        readonly />
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Ekspedisi</dt>
                                    </div>
                                    <select class="select2_demo_3 form-control" name="ekspedisi">
                                        <option></option>
                                        <option value="JNE">JNE</option>
                                        <option value="J&T">J&T</option>
                                        <option value="Anter Aja">Anter Aja</option>
                                    </select>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Ongkir</dt>
                                    </div>
                                    <input style="height: 1.6rem; background-color: transparent;"
                                        onchange="return calcprice(this)" id="ongkir" type="number"
                                        class="ongkir form-control" min="0" max="999999999999" value="0" name="ongkir"
                                        required />
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-left">
                                        <dt>Grand Total</dt>
                                    </div>
                                    <input style="height: 1.6rem; background-color: transparent;"
                                        onchange="return calcprice(this)" id="gtotal" type="number"
                                        class="gtotal form-control" value="0" name="gtotal" required readonly />
                                </div>
                                &nbsp;
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-danger btn-lg" type="reset">Cancel</button>
                                <button class="btn btn-primary btn-lg" type="submit">Save </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<div id="modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog" style="max-width:70%">
        <div class="modal-content">
            <div class="modal-header">
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
                            <li class="nav-item"><a href="#RClass" class="nav-link" role="tab" data-from="classform"
                                    data-toggle="tab">Paket Bundling</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content card-body no-padding" style="padding-bottom: 20px !important;">
                    <div id="Original" class="tab-pane active">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable1" style="width: 100%;" class="table table-striped table-hover datatable1">
                                        <thead>
                                            <tr>
                                                
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
                    <div id="RClass" class="tab-pane">
                        <div id="Original" class="tab-pane active">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="paket" style="width: 100%;" class="table table-striped table-hover paket">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="20%">Code Bundling</th>
                                                    <th width="10%">Judul Bundling</th>
                                                    <th width="45%">Komposisi Item</th>
                                                    <th width="10%">Berat</th>
                                                    <th width="10%">Unit</th>
                                                    <th width="10%">Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                </tr>
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
</div>

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

<script type="text/javascript">



$(document).on("show.bs.modal","#modal-popup",function(){
    $('#datatable1').dataTable().fnClearTable();
    $('#datatable1').dataTable().fnDestroy();
    var e="";
   
    var e = $("#datatable1").DataTable({
       
        // "processing": true,
		// "serverSide": true,
        // "ordering": true,

		// "order": [[ 0, 'asc' ]],
        "ajax":{
        "url": "{{route('jsonproduk')}}",
        "type": "GET",
         }//,
        // "columnDefs": [
        //     {
        //         "targets": [6],
        //         "visible": false
        //     }],
        // "deferRender": true,
        // "aLengthMenu": [[10, 50, 100],[ 10, 50, 100]],
        // "responsive": true,
        

    });


    
    $(document).ready(function() {
        var table = $('#datatable1').DataTable();

        $('#datatable1 tbody').on('click', 'tr', function(e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                var data = $('#datatable1').DataTable().row('.selected').data();

                        $('#modal-popup').modal('hide');

                        var long = $("#tr"+data[0]).length;

                        if(long ==0){
                        $('#tablelistproduk > tbody').append(

                            '<tr class="records" name="id" id="tr'+data[0]+'" data-id="'+data[0]+'">' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="code" name="code[]" value="'+ data[0] +'" readonly /></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="namabrg" name="namabrg[]" value="'+data[1]+'" readonly /></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="harga" name="harga[]" value="'+data[5]+'" readonly /></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="qty'+data[0]+'"   data-price="'+data[5]+'"  data-key="'+data[0]+'"  onchange="return calcprice(this)"  value="1"   class="quantityTxt form-control" type="number"  name="qty[]"></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="diskon'+data[0]+'"  data-price="'+data[5]+'" data-key="'+data[0]+'" onchange="return calcprice(this)" value="0"  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]"></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="total'+data[0]+'" value='+data[5]+'  class="totalprice form-control" type="text"  name="total[]" readonly/></td>' +
                            '<td><button class="remove_item btn-danger" id="'+data[0]+'" onclick="return removetable(this)">Delete</button></td>' +
                            '</tr>'
                        );
                            let btotal=$("#btotal").val();
                            $("#btotal").val(parseFloat(btotal)+parseFloat(data[6]) );
                        }
            }
        });
    });
});

$(document).on("show.bs.modal","#modal-popup",function(){
    // $('#paket').dataTable().fnClearTable();
    // $('#paket').dataTable().fnDestroy();
    var e="";
   
    var e = $("#paket").DataTable({
       
        // "processing": true,
		// "serverSide": true,
        // "ordering": true,

		// "order": [[ 0, 'asc' ]],
        "ajax":{
        "url": "{{route('jsonbundling')}}",
        "type": "GET",
         }//,
        // "columnDefs": [
        //     {
        //         "targets": [6],
        //         "visible": false
        //     }],
        // "deferRender": true,
        // "aLengthMenu": [[10, 50, 100],[ 10, 50, 100]],
        // "responsive": true,
        

    });


    
    $(document).ready(function() {
        var table = $('#paket').DataTable();

        $('#paket tbody').on('click', 'tr', function(e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                var data = $('#paket').DataTable().row('.selected').data();

                        $('#modal-popup').modal('hide');

                        var long = $("#tr"+data[0]).length;

                        if(long ==0){
                        $('#tablelistproduk > tbody').append(

                            '<tr class="records" name="id" id="tr'+data[0]+'" data-id='+data[0]+'>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="code" name="code[]" value=' + data[1] + ' readonly /></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="namabrg" name="namabrg[]" value="'+data[2]+' '+data[3]+'" readonly /></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="harga" name="harga[]" value=' + data[6] + ' readonly /></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="qty'+data[0]+'"   data-price="'+data[6]+'"  data-key="'+data[0]+'"  onchange="return calcprice(this)"  value="1"   class="quantityTxt form-control" type="number"  name="qty[]"></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="diskon'+data[0]+'"  data-price="'+data[6]+'" data-key="'+data[0]+'" onchange="return calcprice(this)" value="0"  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]"></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="total'+data[0]+'" value='+data[6]+'  class="totalprice form-control" type="text"  name="total[]" readonly/></td>' +
                            '<td><button class="remove_item btn-danger" id="'+data[0]+'" onclick="return removetable(this)">Delete</button></td>' +
                            '</tr>'
                        );
                            let btotal=$("#btotal").val();
                            $("#btotal").val(parseFloat(btotal)+parseFloat(data[6]) );
                        }




            }

        });
    });
});


    // Paket
function calcprice(e){
                    let id=e.id;
                    let key=$('#'+id).data('key');
                    let price=$('#'+id).data('price');
                    let qty = $("#qty"+key).val();
                    let diskon = $("#diskon"+key).val();
                    console.log(key);
                    let total=0;
                        if (qty > 2) {
                            total = (price-(price*5/100))*qty;


                            
                        }else{
                            if(diskon > 100){
                            total=(price*qty)-diskon;
                            }else{
                            total = (price-(price*diskon/100))*qty;
                            }
                        }
                       
                        
                    $("#total"+key).val(total);
                    let subtotal=0;
                    $('.totalprice').each(function(index,item){
                        subtotal +=parseFloat(item.value);

                    });
                    $("#btotal").val(subtotal);

                    let grandtotal=subtotal;

                    $('.ongkir').each(function(index,item){
                        let ongkir = $('#ongkir').val();
                        grandtotal = subtotal + parseFloat(ongkir);
                        $("#gtotal").val(grandtotal);

                    });





                }
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





</script>

@stop
