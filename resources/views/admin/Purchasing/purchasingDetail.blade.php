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
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Nama Supplier:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1" id="preferensiname">
                                            <div class="form-group row has-success">
                                                <div class="input-group col-sm-10">
                                                    <input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" value="{{$purchasing->data->supplier}}" type="text" class="form-control" name="supplier"
                                                        id="inputserch" style="height: 1.6rem;"
                                                        disabled>
                                                  
                                                </div>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Email:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1" id="preferensiname">
                                            <div class="form-group row has-success">
                                                <div class="input-group col-sm-10">
                                                    <input value="{{$purchasing->data->email}}" type="text" class="form-control" id="email" name="email"
                                                        style="height: 1.6rem; background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;"  disabled>
                                                </div>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>NPWP:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1" id="preferensiname">
                                            <div class="form-group row has-success">
                                                <div class="input-group col-sm-10">
                                                    <input value="{{$purchasing->data->npwp}}" type="text" class="form-control" name="npwp" id="npwp"
                                                    style="height: 1.6rem; background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;"  disabled>
                                                </div>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="col-lg-6">
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Category:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1" id="preferensiname">
                                            <div class="form-group row has-success">
                                                <div class="input-group col-sm-10">
                                                    <input value="{{$purchasing->data->category}}" autocomplete="off" id="category" type="text"
                                                        class="typeahead2 form-control" name="category" disabled
                                                        style="height: 1.6rem; background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;"  disabled>
                                                </div>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right">
                                        <dt>Addresse:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <dd class="mb-1" id="preferensiname">
                                            <div class="form-group row has-success">
                                                <div class="input-group col-sm-10">
                                                    <textarea  class="form-control"name="addr" id="addr" cols="10" rows="10" style="height: 1.6rem; background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" readonly>{{$purchasing->data->alamat}}</textarea>
                                                </div>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <h2>Detail Barang</h2>
                                    <table id="tablelistproduk" class="table table-striped">
                                        <thead style="background-color:#fff;color:#565151;">
                                            <tr>
                                                <th>Jenis Barang</th>
                                                <th>Nama Item</th>
                                                <th>Harga</th>
                                                <th>Quantity</th>
                                                <th>Diskon</th>
                                                <th>Satuan</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($purchasing->data->detailpurchasing as $detail)
                                            <tr class="records" name="id" id="tr{{$detail->id}}" data-id='{{$detail->id}}'>
                                                <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" type="text" class="form-control" id="nama_item" name="nama_item[]" value='{{$detail->jenis_barang}}' readonly/></td>
                                                <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" type="text" class="form-control" id="nama_item" name="nama_item[]" value='{{$detail->nama}}' readonly/></td>
                                                <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" class="form-control" id="harga" name="harga[]" value='Rp.{{number_format($detail->harga)}}' readonly /></td>
                                                <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" id="qty"   data-price=""  data-key=""  value='{{$detail->qty}}'   class="quantityTxt form-control" type="number"  name="qty[]" readonly></td>
                                                <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" id="diskon"  data-price="" data-key="" value='{{$detail->diskon}}'  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]" readonly></td>
                                                <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" id="satuan" value='{{$detail->satuan}}'  class="totalprice form-control" type="text"  name="satuan[]" readonly/></td>
                                                <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;" id="satuan" value='Rp.{{number_format($detail->total_harga)}}'  class="totalprice form-control" type="text"  name="satuan[]" readonly/></td>
                                                
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <dl class="row mb-0">
                            <div class="col-sm-2 text-sm-right">
                                <dt>Grand Total:</dt>
                            </div>
                            <div class="col-sm-4 text-sm-left">
                                <dd class="mb-1" id="preferensiname">
                                    <div class="form-group row has-success">
                                        <div class="input-group col-sm-10">
                                            <input value="Rp.{{number_format($purchasing->data->grand_total)}}" autocomplete="off" id="totalbayar" type="text"
                                                class="typeahead2 form-control" name="totalbayar" disabled
                                                style="background-color: #fff;border-top:none;border-left:none;border-right:none; background-color: transparent;">
                                        </div>
                                    </div>
                                </dd>
                            </div>
                        </dl>
                        
                        <div class="hr-line-dashed"></div>
                        {{-- <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-danger btn-lg" type="reset">Cancel</button>
                                <button class="btn btn-primary btn-lg" type="submit">Save </button>
                            </div>
                        </div> --}}
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
                    $('#email').val(data[2]);
                    $('#npwp').val(data[3]);
                    $('#addr').val(data[5]);

                }

            });
        });
    });

    $('#target').submit(function (e) {
        var jenis = $('#jenis').val();
        var namai = $('#nama_item').val();
        var harga = $('#harga').val();
        var qty = $('#qty').val();
        var diskon = $('#diskon').val();
        var satuan = $('#satuan').val();
        var totbarang = $("#totbarang").val();




        event.preventDefault();
        $('#modal-popup1').modal('hide');

        var long = $("#"+namai).length;

    if(long ==0){ 
        $('#tablelistproduk > tbody').append(
            '<tr class="records" name="'+ namai +'" id="'+ namai +'" data-id="'+ namai +'">' +
            '<td><input style="border-top:none;border-left:none;border-right:none; background-color: transparent;" type="text" class="form-control" id="jenis" name="jenis[]" value="' +
            jenis + '" readonly/></td>' +
            '<td><input style="border-top:none;border-left:none;border-right:none; background-color: transparent;" type="text" class="form-control" id="nama_item" name="nama_item[]" value="' +
            namai + '" readonly/></td>' +
            '<td><input style="border-top:none;border-left:none;border-right:none; background-color: transparent;" class="form-control harga" id="harga'+namai+'" name="harga[]" value="' +
            harga + '" readonly /></td>' +
            '<td><input style="border-top:none;border-left:none;border-right:none; background-color: transparent;" id="qty"   data-price=""  data-key=""  value="' +
            qty + '"   class="quantityTxt form-control" type="number"  name="qty[]" readonly></td>' +
            '<td><input style="border-top:none;border-left:none;border-right:none; background-color: transparent;" id="diskon"  data-price="" data-key="" value="' +
            diskon +
            '"  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]" readonly></td>' +
            '<td><input style="border-top:none;border-left:none;border-right:none; background-color: transparent;" id="satuan" value="' +
            satuan + '"  class="totalprice form-control" type="text"  name="satuan[]" readonly/></td>' +
            '<td><input style="border-top:none;border-left:none;border-right:none; background-color: transparent;" class="form-control totbarang" id="totbarang" name="totbarang[]" value="' +
            totbarang + '" readonly /></td>' +
            '<td><button class="remove_item btn-danger" id="'+namai+'" onclick="return removetable(this)" >Delete</button></td>' + 
            '</tr>'
        );
    }    


        // untuk total bayar
        let subtotal=0;
        $('.records').each(function(index,item){
            var harga = $('#totbarang').val();
                        subtotal +=parseFloat(harga);
                        console.log(subtotal);
            $('#totalbayar').val(subtotal);
 
        });

        // $(".remove_item").click(function (ev) {
        //     if (ev.type == 'click') {
        //         $(this).parents(".records").fadeOut();
        //         $(this).parents(".records").remove();
        //     }
        // });
    });
    // autocomplete nama item
    $(document).ready(function () {
        var path = "{{route('autocomplete')}}";

        $('input.typeahead').typeahead({
            source: function (query, process) {

                return $.get(path, {
                    query: query
                }, function (data) {
                    return process(data);
                });

            }
        });



    });
    // autocomplete category
    $(document).ready(function () {
        var path = "{{route('autocompletecategory')}}";
        $('input.typeahead2').typeahead({
            source: function (query, process) {

                return $.get(path, {
                    query: query
                }, function (data) {
                    console.log(data);
                    return process(data);


                });
            }
        });



    });

    // autocomplete satuan
    $(document).ready(function () {
        var path = "{{route('autocompletesatuan')}}";
        $('input.typeahead3').typeahead({
            source: function (query, process) {

                return $.get(path, {
                    query: query
                }, function (data) {
                    console.log(data);
                    return process(data);


                });
            }
        });



    });


    // Calculate
    function calcprice(e){
                    
                    let price=$("#harga").val();
                    let qty = $("#qty").val();
                    let diskon = $("#diskon").val();
                    let total=0;
                         if(diskon > 100){
                                total=(price*qty)-diskon;
                                }else{
                                total = (price-(price*diskon/100))*qty;
                    }

                    $("#totbarang").val(total);
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
    $("#"+id).remove();
    let subtotal=0;
    
                    $('.totbarang').each(function(index,item){
                        subtotal +=parseFloat(item.value);
                       
                      
                    });
                    
                    $("#totalbayar").val(subtotal);
                    
                   
}

</script>

@stop