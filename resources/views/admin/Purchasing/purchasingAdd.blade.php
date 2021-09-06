@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Purchasing Add</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/purchasing')}}">purchasing</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add Purchasing</strong>
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
                    
                    <h5>Add Purchasing</h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{url('/purchasing')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="text" name="ponomor" value="{{$purchasing->purchasing +1}}" class="form-control"
                            placeholder="Tambah Suppplier" hidden> --}}

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
                                                    <input type="text" class="form-control" name="supplier"
                                                        id="inputserch" style="none;border-right:none;height: 1.6rem;"
                                                        placeholder="Tambah Suppplier">
                                                    <div class="input-group-prepend">
                                                        <span class="btn input-group-text button-add"
                                                            data-toggle="modal" data-target="#modal-popup"
                                                            style="background: transparent;border-color:#0288d1;border-left: none;border-radius: 0px 4px 4px 0px;height: 1.6rem;">
                                                            <i class="fa fa-plus"></i></span></div>
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
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        style="height: 1.6rem;" placeholder="supplier@xxxxxx" required>
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
                                                    <input type="text" class="form-control" name="npwp" id="npwp"
                                                        placeholder="1111.xxxx.xxxx" required style="height: 1.6rem;">
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
                                                    <input autocomplete="off" id="category" type="text"
                                                        class="typeahead2 form-control" name="category" required
                                                        style="height: 1.6rem;">
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
                                                    <textarea style="background-color: #fff;" class="form-control"
                                                        name="addr" id="addr" cols="10" rows="5"></textarea>
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
                                    <div class="input-group"><input placeholder="Search" type="text"
                                            class="form-control form-control-sm"> <span class="input-group-append"
                                            data-toggle="modal" data-target="#modal-popup1"> <button type="button"
                                                class="btn btn-sm btn-primary">Tambah Data Item
                                            </button> </span></div>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
                                            <input autocomplete="off" id="totalbayar" type="text"
                                                class="typeahead2 form-control" name="totalbayar" required
                                                style="height: 1.6rem; background-color: transparent;" readonly>
                                        </div>
                                    </div>
                                </dd>
                            </div>
                        </dl>
                        
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-danger btn-lg" type="reset">Cancel</button>
                                <button {{-- href="{{route('Purchasing Cetak',$purchasing->purchasing)}}" --}}
                                    class="btn btn-primary btn-lg" type="submit">Save </button>
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
                <h4 id="exampleModalLabel" class="modal-title"> Detail Data Supplier </h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item"><a href="#Original" class="nav-link show active"
                                    data-from="originalform" role="tab" data-toggle="tab">Data Supplier</a></li>
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
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #fff; color: #0c0b0b; ">
                <h4 id="exampleModalLabel" class="modal-title"> Input Purchasing Item </h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="target" action="" method="POST" enctype="multipart/form-data">
                    <div class="input-group col-sm-9">
                        <div class="col-sm-5 text-sm-right">
                            <dt>Jenis Barang</dt>
                        </div>
                        <select id="jenis"  class="form-control m-b" name="jenis" id="jenis">
                            <option value="0"></option>
                            @foreach($jenis->data as $row)
                                <option value="{{$row->nama}}">{{$row->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="input-group col-sm-9">
                        <div class="col-sm-5 text-sm-right">
                            <dt>Nama Item</dt>
                        </div>
                        <input autocomplete="off" style="height: 1.6rem; autocomplete=" off" type="text"
                            class="typeahead form-control" id="nama_item" name="nama_item" placeholder="" required>
                    </div>
                    <br>
                    <div class="input-group col-sm-9">
                        <div class="col-sm-5 text-sm-right">
                            <dt>Harga</dt>
                        </div>
                        <input onchange="return calcprice(this)" style="height: 1.6rem;" autocomplete="off" type="number" class="form-control" id="harga"
                            name="harga" placeholder="" required>
                    </div>
                    <br>
                    <div class="input-group col-sm-9">
                        <div class="col-sm-5 text-sm-right">
                            <dt>Quantity</dt>
                        </div>
                        <input onchange="return calcprice(this)"  style="height: 1.6rem;" type="number" class="form-control" id="qty" name="qty"
                            placeholder="" required>
                    </div>
                    <br>
                    <div class="input-group col-sm-9">
                        <div class="col-sm-5 text-sm-right">
                            <dt>Diskon</dt>
                        </div>
                        <input onchange="return calcprice(this)" style="height: 1.6rem;" type="number" class="form-control" id="diskon" name="diskon"
                            placeholder="" required>
                    </div>
                    <br>
                    <div class="input-group col-sm-9">
                        <div class="col-sm-5 text-sm-right">
                            <dt>Satuan</dt>
                        </div>
                        <input style="height: 1.6rem;" autocomplete="off" type="text" class="typeahead3 form-control"
                            id="satuan" name="satuan" placeholder="" required>
                    </div>
                    <br>
                    <div class="input-group col-sm-9">
                        <div class="col-sm-5 text-sm-right">
                            <dt>Total Barang</dt>
                        </div>
                        <input onchange="return calcprice(this)" style="height: 1.6rem;" autocomplete="off" type="number" class="typeahead3 form-control"
                            id="totbarang" name="totbarang" placeholder="" required>
                    </div>
                    <br> 
                    <div class="form-group row">
                        <div class="col-sm-12 col-sm-offset-2">
                            <button class="btn btn-danger btn-lg" type="reset">Reset</button>
                            <button id="lanjut" class="btn btn-primary btn-lg" type="submit">Lanjut </button>
                        </div>
                    </div>
                </form>
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
<script src="{{asset('assets/js/plugins/typehead/bootstrap3-typeahead.min.js')}}"></script>





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
                harga+ '" readonly /></td>' +
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
