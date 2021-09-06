<!DOCTYPE html>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4">
        <h2>Invoice</h2>
    </div>

    <div class="col-lg-8">
        <div class="title-action">
            <form action="{{url('/edit_tglkirim' , $purchasing->purchasing->id)}}" method="POST" enctype="multipart/form-data">
            @csrf

            <a  class="btn btn-white">Pilih tanggal kirim barang </a>
            <input type="date" value="{{ $purchasing->purchasing->tgl_kirim }}" name="tgl_kirim" class="form-default">
            <button id="save" class="btn btn-white" type="submit"><i class="fa fa-check "></i> Save </button>
            <button  id="print" class="btn btn-primary" type="button"><i class="fa fa-print"></i> Print Invoice </button>
            </form>
            {{-- href="{{route('Edit Purchasing',$purchasing->purchasing->id)}}" --}}
        </div>
    </div>
</div>
<html>
<div id="white-bg">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bizplan.id | Invoice Print</title>

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

</head>


<body class="white-bg" >

                <div   class="wrapper wrapper-content p-xl">
                    <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>From:</h5>
                                    <address>
                                        <strong>{{$setting->data->nama}}.</strong><br>
                                        {{$setting->data->addr}}<br>
                                        {{$setting->data->kab}} , {{$setting->data->kec}}, {{$setting->data->kel}}, {{$setting->data->kode_pos}}<br>
                                        <abbr title="Phone">P: {{$setting->data->hp}}</abbr> / {{$setting->data->tlp}}
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy">INV-{{ $purchasing->purchasing->id }}</h4>
                                    <span>To:</span>
                                    <address>
                                        <strong>{{ $purchasing->purchasing->supplier }}</strong><br>
                                        {{ $purchasing->purchasing->alamat }}<br>

                                        <abbr title="Email">Email:</abbr> {{ $purchasing->purchasing->email }}
                                    </address>
                                    <p>
                                        <span><strong>Invoice Date:</strong> {{ $purchasing->purchasing->created_at }}</span><br/>


                                        <span><strong>Due Date:</strong>  </span>
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table >
                                    <thead>
                                    <tr>
                                        <th width="40%">Nama Barang</th>
                                        <th width="15%">Harga</th>
                                        <th width="15%">Quantity</th>
                                        <th width="15%">Diskon</th>
                                        <th width="10%">Unit</th>
                                    </tr>
                                    </thead>
                                    <tbody class="invoice-table">
                                        @foreach($purchasing->purchasing->detailpurchasing as $detail)
                                        <tr class="records" name="id" id="tr{{$detail->id}}" data-id='{{$detail->id}}'>
                                            <td width="40%"><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" type="text" class="form-control" id="nama_item" name="nama_item[]" value='{{$detail->nama}}' readonly/></td>
                                            <td width="15%"><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="harga" name="harga[]" value='{{$detail->harga}}' readonly /></td>
                                            <td width="15%"><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="qty"   data-price=""  data-key=""  value='{{$detail->qty}}'   class="quantityTxt form-control" type="number"  name="qty[]" readonly></td>
                                            <td width="15%"><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="diskon"  data-price="" data-key="" value='{{$detail->diskon}}'  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]" readonly></td>
                                            <td width="10%"><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="satuan" value='{{$detail->satuan}}'  class="totalprice form-control" type="text"  name="satuan[]" readonly/></td>
                                            </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
                            <br>
                            {{-- <table class="table invoice-total">
                                <tbody>
                                <tr>
                                    <td><strong>Sub Total :</strong></td>
                                    <td>$1026.00</td>
                                </tr>
                                <tr>
                                    <td><strong>TAX :</strong></td>
                                    <td>$235.98</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td>$1261.98</td>
                                </tr>
                                </tbody>
                            </table> --}}
                            <div class="well m-t"><strong>Comments</strong>
                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                            </div>
                        </div>

    </div>


</div>
</body>

</html>
<!-- Mainly scripts -->


<script src="{{asset('assets/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
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

<!-- Custom and plugin javascript -->


<script type="text/javascript">
// $('#save').click(function(){
//     event.preventDefault();
//     console.log("berhasil");
// });

$('#print').click(function(){
    var divName= "white-bg";

                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
                event.preventDefault();
});

</script>


<!-- Start Back up purchasing Detail -->
@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Purchasing</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> 
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/purchasing')}}">purchasing</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail Purchasing</strong>
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
                    <h5>Purchasing <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{url('/purchasing')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="{{url('/edit_purchasing' , $purchasing->data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nama Supplier</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope-square"></i></span>
                                </div>
                                <span value="{{$purchasing->data->supplier}}" type="text" name="supplier" id="inputserch" class="form-control" placeholder="Tambah Suppplier">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-popup"><i class="fa fa-plus"></i></button>

                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Email</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope-square"></i></span>
                                </div>
                                <input value="{{$purchasing->data->email}}" id="email" type="email" class="form-control" name="email"
                                    placeholder="supplier@xxxxxx" required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">NPWP</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                                </div>
                                <input value="{{$purchasing->data->npwp}}" id="npwp" type="text" class="form-control" name="npwp"
                                    placeholder="1111.xxxx.xxxx" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 font-weight-bold col-form-label">Address</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="addr" id="addr" cols="10" rows="5">{{$purchasing->data->alamat}}</textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed "></div>
                        <div class="form-group row ">
                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Category</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                                </div>
                                <input value="{{$purchasing->data->category}}" type="text" class="form-control" name="category" placeholder="" required>
                            </div>

                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nama Item</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                </div>
                                <input type="text" class="form-control"  placeholder="Tambah Data Item"
                                    readonly>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-popup1"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        {{-- Detail Barang --}}
                        {{-- <div class="hr-line-dashed"></div> --}}
                        <div class="form-group row">
                            <div class="col-lg-12">
                                        <h3 class="h4">Detail Item Barang</h3>
                                    {{-- <div class="card-body"> --}}
                                        <div class="form-group">
                                        </div>
                                        <div class="table-responsivemobile">
                                            <table class="tablemobile" id="tablelistproduk" style="font-size:14px">
                                                <thead class="theadmobile">
                                                    <tr class="trmobile">

                                                        <th class="thmobile" width="50%">Nama Item</th>
                                                        <th class="thmobile" width="20%">Harga</th>
                                                        <th class="thmobile" width="10%">Quantity</th>
                                                        <th class="thmobile" width="10%">Diskon</th>
                                                        <th class="thmobile" width="10%">Satuan</th>
                                                        <th class="thmobile" width="20%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="barangdetail" class="tbodymobile">
                                                @foreach($purchasing->data->detailpurchasing as $detail)
                                                <tr class="records" name="id" id="tr{{$detail->id}}" data-id='{{$detail->id}}'>
                                                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" type="text" class="form-control" id="nama_item" name="nama_item[]" value='{{$detail->nama}}' readonly/></td>
                                                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="harga" name="harga[]" value='{{$detail->harga}}' readonly /></td>
                                                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="qty"   data-price=""  data-key=""  value='{{$detail->qty}}'   class="quantityTxt form-control" type="number"  name="qty[]" readonly></td>
                                                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="diskon"  data-price="" data-key="" value='{{$detail->diskon}}'  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]" readonly></td>
                                                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="satuan" value='{{$detail->satuan}}'  class="totalprice form-control" type="text"  name="satuan[]" readonly/></td>
                                                    <td><input  type="button" class="remove_item btn-danger" id="{{$detail->id}}" onclick="return removetable(this)" value="Delete"></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    {{-- </div> --}}
                                </div>
                        </div>
                        {{-- End Detail Barang --}}
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
                                                <th width="10%">code</th>
                                                <th width="10%">Nama Supplier</th>
                                                <th width="10%">Email</th>
                                                <th width="10%">npwp</th>
                                                <th width="40%">hp</th>
                                                <th width="20%">alamat</th>
                                                <th width="5%">#</th>

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

{{-- Modal popup tambah item --}}
<div id="modal-popup1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog" style="max-width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title"> Input Purchasing Item </h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="target" action="" method="POST" enctype="multipart/form-data">
                    <div class="input-group col-sm-6">
                        <label class="col-sm-12 font-weight-bold col-form-label">Nama Item</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-"></i></span>
                        </div>
                        <input type="text" class="nama_item form-control" id="nama_item" name="nama_item" placeholder="" required>
                    </div>
                    <div class="input-group col-sm-6">
                        <label class="col-sm-12 font-weight-bold col-form-label">Harga</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-"></i></span>
                        </div>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="" required>
                    </div>
                    <div class="input-group col-sm-6">
                        <label class="col-sm-12 font-weight-bold col-form-label">Quantity</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-"></i></span>
                        </div>
                        <input type="number" class="form-control" id="qty" name="qty" placeholder="" required>
                    </div>
                    <div class="input-group col-sm-6">
                        <label class="col-sm-12 font-weight-bold col-form-label">Diskon</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-"></i></span>
                        </div>
                        <input type="number" class="form-control" id="diskon" name="diskon" placeholder="" required>
                    </div>
                    <div class="input-group col-sm-6">
                        <label class="col-sm-12 font-weight-bold col-form-label">Satuan</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-product"></i></span>
                        </div>
                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="" required>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-danger btn-lg" type="reset">Reset</button>
                            <button id="lanjut" class="btn btn-primary btn-lg" type="submit">Lanjut </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Modal popup tambah item end--}}
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
                        window.location = '/add_purchasing';
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

    $(document).on("show.bs.modal", "#modal-popup", function () {
        var e = "";
        var e = $("#datatable1").DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,

            "order": [
                [0, 'asc']
            ],
            "ajax": {
                "url": "{{route('jsonsupplier')}}",
                "type": "GET",
            },
            "columnDefs": [{
                "targets": [7],
                "visible": false
            }],
            "deferRender": true,
            "aLengthMenu": [
                [10, 50, 100],
                [10, 50, 100]
            ],
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
                    $('#inputserch').val(data[1]);
                    $('#npwp').val(data[3]);
                    $('#addr').val(data[5]);







                }

            });
        });
    });

    $('#target').submit(function (e) {
        var namai = $('#nama_item').val();
        var harga = $('#harga').val();
        var qty = $('#qty').val();
        var diskon = $('#diskon').val();
        var satuan = $('#satuan').val();




        event.preventDefault();
        $('#modal-popup1').modal('hide');
        $('#tablelistproduk > tbody').append(
            '<tr class="records" name="id">' +
            '<td><input type="text" class="form-control" id="nama_item" name="nama_item[]" value='+namai+'/></td>' +
            '<td><input class="form-control" id="harga" name="harga[]" value=' + harga + ' readonly /></td>' +
            '<td><input id="qty"   data-price=""  data-key=""  value="'+qty+'"   class="quantityTxt form-control" type="number"  name="qty[]"></td>' +
            '<td><input id="diskon"  data-price="" data-key="" value="'+diskon+'"  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]"></td>' +
            '<td><input id="satuan" value='+satuan+'  class="totalprice form-control" type="text"  name="satuan[]" readonly/></td>' +
            '<td><button class="remove_item btn-danger" id="remove_item" >Delete</button></td>' +
            '</tr>'
            );
            $(".remove_item").click(function (ev) {
                if (ev.type == 'click') {
                $(this).parents(".records").fadeOut();
                $(this).parents(".records").remove();
                }
            });
    });

    // Paket
    // function calcprice(e) {
    //     let id = e.id;
    //     let key = $('#' + id).data('key');
    //     let price = $('#' + id).data('price');
    //     let qty = $("#qty" + key).val();
    //     let diskon = $("#diskon" + key).val();

    //     let total = 0;
    //     if (diskon > 100) {
    //         total = (price * qty) - diskon;
    //     } else {
    //         total = (price - (price * diskon / 100)) * qty;
    //     }

    //     $("#total" + key).val(total);
    //     let subtotal = 0;
    //     $('.totalprice').each(function (index, item) {
    //         subtotal += parseFloat(item.value);

    //     });
    //     $("#btotal").val(subtotal);

    //     let grandtotal = subtotal;

    //     $('.ongkir').each(function (index, item) {
    //         let ongkir = $('#ongkir').val();
    //         grandtotal = subtotal + parseFloat(ongkir);
    //         $("#gtotal").val(grandtotal);

    //     });





    // }

    function removetable(e) {
        let id=e.id;
    $("#tr"+id).remove();

    }
</script>

@stop

<!-- Emd Back up purchasing Detail -->