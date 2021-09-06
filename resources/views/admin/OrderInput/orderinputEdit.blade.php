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
                        <a class="btn "  href="{{url('/order_input')}}" title="back">
                           <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="{{url('/edit_order_input' , $OrderInput->data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">sumber sales</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-address-book"></i></span>
                                </div>
                                <select class="select2_demo_3 form-control" name="sumber_sales">
                                    <option value="{{$OrderInput->data->sumber_sales}}">{{$OrderInput->data->sumber_sales}}</option>
                                    <option value="Marketplace">Marketplace</option>
                                    <option value="WhatsApp">WhatsApp</option>
                                    <option value="Instagram">Instagram</option>
                                </select>
                            </div>
                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nomer Telepon</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                                </div>
                                <input type="number" value="{{$OrderInput->data->no_tlp}}" class="form-control" name="no_tlp" placeholder="021xxxxx" required>
                            </div>
                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nama Customer</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope-square"></i></span>
                                </div>
                                <input type="text" value="{{$OrderInput->data->nama}}" class="form-control" name="nama" placeholder="input nama customer"
                                    required>
                            </div>
                        </div>

                        <div class="hr-line-dashed "></div>
                        <div class="form-group row ">

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Provinsi</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                </div>
                                <input type="text" value="{{$OrderInput->data->prov}}" class="form-control" name="prov" placeholder="Banten" required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Kabupaten</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                </div>
                                <input type="text" value="{{$OrderInput->data->kab}}" class="form-control" name="kab" placeholder="Kab.Tangerang" required>
                            </div>
                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Kecamatan</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                </div>
                                <input type="text" value="{{$OrderInput->data->kec}}" class="form-control" name="kec" placeholder="Tangerang" required>
                            </div>
                        </div>





                        <div class="form-group row">
                            <label class="col-sm-12 font-weight-bold col-form-label">Alamat Lengkap</label>
                            <div class="col-sm-12">
                                <textarea  class="form-control" name="addr" id="" cols="10" rows="5">{{$OrderInput->data->addr}}</textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed "></div>
                        <div class="form-group row ">
                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Kode Pos</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                </div>
                                <input type="number" value="{{$OrderInput->data->kode_pos}}" class="form-control" name="kode_pos" placeholder="08xxxxx" required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Type Pembayaran</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                </div>
                                <select class="select2_demo_3 form-control" name="pembayaran">
                                    <option value="{{$OrderInput->data->pembayaran}}">{{$OrderInput->data->pembayaran}}</option>
                                    <option value="Bayar via marketplace">Bayar via marketplace</option>
                                    <option value="Transfer Bni">Transfer Bni</option>
                                    <option value="Transfer Bca">Transfer Bca</option>
                                </select>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Keterangan Pembayaran</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" value="{{$OrderInput->data->ket_pembayaran}}" class="form-control" name="ket_pembayaran" placeholder="Keterangan Pembayaran" required>
                            </div>
                        </div>


                        {{-- Detail Barang --}}
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                        <h3 class="h4">Detail Item Barang</h3>
                                    <div class="card-body">
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
                                                <thead class="theadmobile">
                                                    <tr class="trmobile">
                                                        <th class="thmobile" width="5%">Code</th>
                                                        <th class="thmobile" width="10%">Nama Barang / Berat</th>
                                                        <th class="thmobile" width="10%">Price</th>
                                                        <th class="thmobile" width="10%">Qty</th>
                                                        <th class="thmobile" width="10%">[% atau nominal]</th>
                                                        <th class="thmobile" width="10%">Total Price</th>
                                                        <th class="thmobile" width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="barangdetail" class="tbodymobile">
                                                @foreach($OrderInput->data->detailorder as $detail)
                                                <tr class="records" name="id" id="tr{{$detail->code}}" data-id='{{$detail->code}}'>
                                                    <td><input class="form-control" id="code" name="code[]" value='{{$detail->code}}' readonly /></td>
                                                    <td><input class="form-control" id="namabrg" name="namabrg[]" value='{{$detail->nama}}' readonly /></td>
                                                    <td><input class="form-control" id="harga" name="harga[]" value='{{$detail->harga}}' readonly /></td>
                                                    <td ><input id="qty{{$detail->code}}"   data-price="{{$detail->harga}}"  data-key="{{$detail->code}}"  onchange="return calcprice(this)"  value="{{$detail->qty}}"   class="quantityTxt form-control" type="number"  name="qty[]"></td>
                                                    <td ><input id="diskon{{$detail->code}}"  data-price="{{$detail->harga}}" data-key="{{$detail->code}}" onchange="return calcprice(this)" value="{{$detail->diskon}}"  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]"></td>
                                                    <td ><input id="total{{$detail->code}}" value='{{$detail->total_price}}'  class="totalprice form-control" type="text"  name="total[]" readonly/></td>
                                                    <td><input type="button" class="remove_item btn-danger" id="{{$detail->code}}" onclick="return removetable(this)" value="Delete"></td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        {{-- End Detail Barang --}}
                        <div class="input-group col-sm-4">
                            <label class="col-sm-12 font-weight-bold col-form-label">Sub total</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                            </div>
                            <input id="btotal" type="number" value="{{$OrderInput->data->sub_total}}" class="form-control" value="0" name="btotal"  required readonly/>
                        </div>
                        <div class="input-group col-sm-4">
                            <label class="col-sm-12 font-weight-bold col-form-label">Ekspedisi</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                            </div>
                            <select class="select2_demo_3 form-control" name="ekspedisi">
                                <option value="{{$OrderInput->data->ekspedisi}}">{{$OrderInput->data->ekspedisi}}</option>
                                <option value="JNE">JNE</option>
                                <option value="J&T">J&T</option>
                                <option value="Anter Aja">Anter Aja</option>
                            </select>
                        </div>
                        <div class="input-group col-sm-4">
                            <label class="col-sm-12 font-weight-bold col-form-label">Ongkir</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                            </div>
                            <input onchange="return calcprice(this)"  id="ongkir" type="number" class="ongkir form-control" min="0" max="999999999999" value="{{$OrderInput->data->ongkir}}" name="ongkir"  required />
                        </div>
                        <div class="input-group col-sm-4">
                            <label class="col-sm-12 font-weight-bold col-form-label">Grand Total</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                            </div>
                            <input onchange="return calcprice(this)" id="gtotal" type="number" class="gtotal form-control" value="{{$OrderInput->data->grand_total}}" name="gtotal"  required readonly/>
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


<div id="modal-popup" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
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
                                    data-toggle="tab">Paket Produk</a></li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content card-body no-padding" style="padding-bottom: 20px !important;">
                    <div id="Original" class="tab-pane active">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable1" style="width: 100%;" class="table table-striped table-hover">
                                        <thead>

                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="10%">Code</th>
                                                <th width="45%">Nama Item</th>
                                                <th width="10%">Brand</th>
                                                <th width="10%">Berat</th>
                                                <th width="10%">Unit</th>
                                                <th width="10%">Harga</th>
                                                <th width="10%">Action</th>
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
                                        <table id="Paket" style="width: 100%;" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="10%">Code Paket</th>
                                                    <th width="10%">Nama Paket</th>
                                                    <th width="45%">Komposisi Item</th>
                                                    <th width="10%">Berat</th>
                                                    <th width="10%">Unit</th>
                                                    <th width="10%">Harga</th>
                                                    <th width="10%">#</th>
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

$(document).ready(function () {
        $('#').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgtip',
            buttons: [{
                    className: 'btn-primary btn-sm ladda-button',
                    titleAttr: 'Add Data',
                    text: '<i class="fa fa-plus" aria-hidden="true"></i>',
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button')
                    },
                    action: function (e, dt, node, config) {
                        window.location = '/add_order_input';
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

$(document).on("show.bs.modal","#modal-popup",function(){
    var e="";
    // $('#datatable1').dataTable().fnClearTable();
    // $('#datatable1').dataTable().fnDestroy();
    var e = $("#datatable1").DataTable({
        "processing": true,
		"serverSide": true,
        "ordering": true,

		"order": [[ 0, 'asc' ]],
        "ajax":{
        "url":"{{route('jsonproduk')}}",
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


    // $('#datatable1 tbody').on('dblclick', 'tr', function () {

    //     let b=e.row((this) ).data();
    //     if(b !==undefined){
    //         let code=b[1];
    //             $("#inputserch").val(code);
    //             $("#modal-popup").modal("hide");
    //             detailtable();

    //     }

    // } );





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

                            '<tr class="records" name="id" id="tr'+data[0]+'" data-id='+data[0]+'>' +
                            '<td><input class="form-control" id="code" name="code[]" value=' + data[1] + ' readonly /></td>' +
                            '<td><input class="form-control" id="namabrg" name="namabrg[]" value=' + data[2] + ' readonly /></td>' +
                            '<td><input class="form-control" id="harga" name="harga[]" value=' + data[6] + ' readonly /></td>' +
                            '<td ><input id="qty'+data[0]+'"   data-price="'+data[6]+'"  data-key="'+data[0]+'"  onchange="return calcprice(this)"  value="1"   class="quantityTxt form-control" type="number"  name="qty[]"></td>' +
                            '<td ><input id="diskon'+data[0]+'"  data-price="'+data[6]+'" data-key="'+data[0]+'" onchange="return calcprice(this)" value="0"  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]"></td>' +
                            '<td ><input id="total'+data[0]+'" value='+data[6]+'  class="totalprice form-control" type="text"  name="total[]" readonly/></td>' +
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

                    let total=0;
                         if(diskon > 100){
                                total=(price*qty)-diskon;
                                }else{
                                total = (price-(price*diskon/100))*qty;
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
