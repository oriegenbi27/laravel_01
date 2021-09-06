@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Produk Add</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/produk')}}">Produk</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Produk Add</strong>
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
                    <h5>Add Produk <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{url('/produk')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- List Input bagian kiri --}}
                            <div class="col-lg-6">
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Code</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        value="{{$produk->data->code}}" name="code" placeholder="Input Code Barang"
                                        required>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Nama Produk</dt>
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        value="{{$produk->data->nama}}" name="nama" placeholder="Nama Produk" required>
                                </div>
                                &nbsp;
                                <div class="input-group col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Brand</dt>
                                    </div>
                                    <select class="form-control m-b" name="brand_id" id="brand_id">
                                        <option value="{{$produk->data->brand_id}}">
                                            @foreach ($produk->data->brand as $row)
                                            {{$row->nama}}
                                            @endforeach
                                        </option>
                                        @foreach($brand->data as $row)
                                        <option value="{{$row->id}}">{{$row->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                &nbsp;
                                <div class="input-group col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Jenis Produk / Jenis Barang</dt>
                                    </div>
                                    <select id="jenis" class="form-control m-b" name="jenis_barang_id"
                                        id="jenis_barang_id">
                                        <option value="{{$produk->data->jenis_barang_id}}">
                                            @foreach ($produk->data->jenisbarang as $row)
                                            {{$row->nama}}
                                            @endforeach
                                        </option>
                                        @foreach($jenis->data as $row)
                                        <option value="{{$row->id}}">{{$row->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                &nbsp;
                                <div class="input-group col-sm-8">
                                    <div class="col-sm-4  text-sm-right">
                                        <dt>Sub Jenis Produk</dt>
                                    </div>
                                    <select class="form-control m-b " name="sub_jenis_barang_id"
                                        id="sub_jenis_barang_id">
                                        <option value="{{$produk->data->sub_jenis_id}}">
                                            @foreach ($produk->data->subjenis as $row)
                                            {{$row->nama}}
                                            @endforeach
                                        </option>
                                        @foreach($subjenis->data as $row)
                                        <option value="{{$row->id}}">{{$row->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                &nbsp;
                            </div>
                            {{-- List input Kanan --}}
                            <div class="col-lg-6">
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Harga</dt>
                                    </div>
                                    <input value="{{$produk->data->harga}}" onchange="return calprice(this)" style="height: 1.6rem;" name="harga"
                                        id="harga" type="number" class="form-control" aria-label="Harga">
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Diskon</dt>
                                    </div>
                                    <input value="{{$produk->data->diskon}}" onchange="return calprice(this)" style="height: 1.6rem;" type="number"
                                        name="diskon" id="diskon" class="form-control" aria-label="Diskon">
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Berat</dt>
                                    </div>
                                    <input value="{{$produk->data->berat}}" style="height: 1.6rem;" type="number"
                                        name="berat" id="berat" class="form-control" aria-label="Berat">
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Stock</dt>
                                    </div>
                                    <input value="{{$produk->data->stock}}" style="height: 1.6rem;" type="text"
                                        name="stock" id="stock" class="form-control" aria-label="Stock">
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Unit</dt> 
                                    </div>
                                    <select name="unit" id="unit" class="form-control">
                                        <option value="{{$produk->data->unit}}">{{$produk->data->unit}}</option>
                                        @foreach ($satuan->data as $row )
                                        <option value="{{$row->code}}">{{$row->code}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Total Harga</dt>
                                    </div>
                                    <input style="height: 1.6rem; background-color: transparent;"
                                        onchange="return calprice(this)" value="{{$produk->data->total_harga}}" readonly name="totalharga" id="totalharga" type="text"
                                        class="form-control" aria-label="Harga">
                                </div>
                            </div>
                        </div>
                       

                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                          
                            {{-- <label class="col-sm-12 font-weight-bold col-form-label">Images</label>
                            <div class="col-sm-12">
                                
                                <input name="images" value="{{Config::get('constant.endpoint.url')}}/storage/produk/{{$produk->data->images}}" type="file" class="form-control">
                            </div> --}}
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <span class="btn btn-outline-default btn-file btn-round" >
                                    <span class="fileinput-new btn btn-xs btn-primary"><i class="fa fa-camera"></i> Add Photo</span>
                                    <span class="fileinput-exists btn btn-xs btn-primary"><i class="fa fa-camera"></i> Add Photo</span>
                                    <input id="imagesphotojson"  type="file" ><input id="imagesphotojsn" name="images" type="file" ></span>
                                    <div class="fileinput-new thumbnail img-circle img-no-padding" style="width: 250px; height: 250px;">
                                        @if(isset($produk->data->images))
                                            <img src="{{Config::get('constant.endpoint.url')}}/storage/produk/{{$produk->data->images}}">
                                            @else
                                            <img src="{{asset('assets/img/blankphoto.jpg')}}" alt="...">
                                        @endif;        
                                    
                                    </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail img-circle img-no-padding" style="max-width:250px; max-height: 250px;"></div>
                                    <div>
                                        <br>
                                    </div>
                            </div>
                        </div>
                      
                        {{-- Start Komposisi item --}}
                        {{-- <div class="col-lg-12"> --}}
                        @if ($produk->data->jenis_barang_id == 8)
                        {{-- <div class="ibox-content"> --}}
                        <div hidden class="table-responsive" id="komposisi">
                            <div class="input-group"><input placeholder="Tambah Komposisi Item" type="text"
                                    class="form-control form-control-sm" readonly> <span class="input-group-append"
                                    data-toggle="modal" data-target="#modal-popup"> <button type="button"
                                        class="btn btn-sm btn-primary"><i style="width: 60px" class="fa fa-plus"></i>
                                    </button> </span></div>
                            <table id="tablelistproduk" class="table table-striped">
                                <thead style="background-color:#fff;color:#565151;">
                                    <tr>
                                        <th width="10%">ID</th>
                                        <th width="50%">Nama Item</th>
                                        {{-- <th>Harga</th> --}}
                                        <th width="10%">Stock</th>
                                        <th width="10%">Berat</th>
                                        <th width="10%">Satuan</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        {{-- </div> --}}
                        @else
                        {{-- <div class="ibox-content"> --}}
                        <div class="table-responsive" id="komposisi">
                            <div class="input-group"><input placeholder="Tambah Komposisi Item" type="text"
                                    class="form-control form-control-sm" readonly> <span class="input-group-append"
                                    data-toggle="modal" data-target="#modal-popup"> <button type="button"
                                        class="btn btn-sm btn-primary"><i style="width: 60px" class="fa fa-plus"></i>
                                    </button> </span></div>
                            <table id="tablelistproduk" class="table table-striped">
                                <thead style="background-color:#fff;color:#565151;">
                                    <tr>
                                        <th width="10%">ID</th>
                                        <th width="50%">Nama Item</th>
                                        {{-- <th>Harga</th> --}}
                                        <th width="10%">Quantity</th>
                                        {{-- <th width="10%">Berat</th> --}}
                                        <th width="10%">Satuan</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produk->data->detailproduk as $row)
                                    <tr class="records" name="id" id="tr{{$row->id}}" data-id="{{$row->id}}">
                                        <td><input
                                                style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;"
                                                class="form-control" id="id" name="idkom[]"
                                                value="{{$row->id_komposisi}}" readonly /></td>
                                        <td><input
                                                style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;"
                                                class="form-control" id="namakom" name="namakom[]"
                                                value="{{$row->nama}}" readonly /></td>
                                        <td><input
                                                style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;"
                                                class="form-control" id="stockkom" name="qtykom[]"
                                                value="{{$row->qty}}" /></td>
                                        <td><input
                                                style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;"
                                                class="form-control" id="satuankom" name="satuankom[]"
                                                value="{{$row->satuan}}" readonly /></td>
                                        <td><button class="remove_item btn-danger" id="{{$row->id}}"
                                                onclick="return removetable(this)">Delete</button></td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        {{-- </div> --}}
                        @endif

                        {{-- </div>  --}}
                        {{-- End Komposisi item  --}}
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <input type="hidden" name="id" value="{{$produk->data->id}}">
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
                                        <thead style="background-color:#fff;color:#565151;">
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
                                                    <th width="20%">Code Paket</th>
                                                    <th width="10%">Nama Paket</th>
                                                    <th width="45%">Komposisi Item</th>
                                                    <th width="10%">Berat</th>
                                                    <th width="10%">Unit</th>
                                                    <th width="10%">Harga</th>
                                                    <th width="5%">#</th>
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
{{-- End pop up komposisi --}}

@endsection
@section('css')
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet"
    href="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/css/buttons.dataTables.min.css')}}">
    <link href="{{asset('assets/css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">   
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
<script src="{{asset('assets/js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

<!-- Mainly scripts -->
<!-- Typehead -->
<script src="{{asset('assets/js/plugins/typehead/bootstrap3-typeahead.min.js')}}"></script>
<script>
    $(document).on("show.bs.modal", "#modal-popup", function () {
        var e = "";
        // $('#datatable1').dataTable().fnClearTable();
        // $('#datatable1').dataTable().fnDestroy();
        var e = $("#datatable1").DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,

            "order": [
                [0, 'asc']
            ],
            "ajax": {
                "url": "{{route('jsonproduk')}}",
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


        // $('#datatable1 tbody').on('dblclick', 'tr', function () {

        //     let b=e.row((this) ).data();
        //     if(b !==undefined){
        //         let code=b[1];
        //             $("#inputserch").val(code);
        //             $("#modal-popup").modal("hide");
        //             detailtable();

        //     }

        // } );





        $(document).ready(function () {
            var table = $('#datatable1').DataTable();

            $('#datatable1 tbody').on('click', 'tr', function (e) {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                    var data = $('#datatable1').DataTable().row('.selected').data();
                    console.log(data);
                    $('#modal-popup').modal('hide');

                    var long = $("#tr" + data[0]).length;

                    if (long == 0) {
                        $('#tablelistproduk > tbody').append(

                            '<tr class="records" name="id" id="tr' + data[0] +
                            '" data-id=' + data[0] + '>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" class="form-control" id="id" name="idkom[]" value="' +
                            data[1] + '" readonly /></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" class="form-control" id="namakom" name="namakom[]" value="' +
                            data[2] + '" readonly /></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; " class="form-control" id="qtykom" name="qtykom[]" value=""  /></td>' +
                            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" class="form-control" id="satuankom" name="satuankom[]" value="' +
                            data[5] + '" readonly /></td>' +
                            '<td><button class="remove_item btn-danger" id="' + data[0] +
                            '" onclick="return removetable(this)">Delete</button></td>' +
                            '</tr>'
                        );
                        let btotal = $("#btotal").val();
                        $("#btotal").val(parseFloat(btotal) + parseFloat(data[6]));
                    }




                }

            });
        });
    });
    // Logic Cek Box

    $("#jenis").change(function () {
        var jenis = $('#jenis').val();
        console.log(jenis);
        if ($('#jenis').val() == 8) {
            console.log("Bahan Baku");
            $('#komposisi').attr('hidden', 'hidden');
        } else if ($('#jenis').val() == 9) {
            console.log("Produk Utama");
            $('#komposisi').removeAttr('hidden');

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


    function removetable(e) {
        let id = e.id;
        $("#tr" + id).remove();
        // let subtotal=0;
        // let grandtotal=0;
        //                 $('.totalprice').each(function(index,item){
        //                     subtotal +=parseFloat(item.value);
        //                     grandtotal +=parseFloat(item.value);
        //                 });
        //                 $("#btotal").val(subtotal);
        //                 $("#gtotal").val(grandtotal);
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
