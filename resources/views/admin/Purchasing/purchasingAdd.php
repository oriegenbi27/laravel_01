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
                <strong>purchasing Add</strong>
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
                    <?php $no_order="anjay mabar"; ?>
                    <h5>PO Nomor : {{$purchasing->purchasing +1}} </h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{url('/purchasing')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf

                            <label class="col-sm-12 font-weight-bold col-form-label" hidden>Nama Supplier</label>
                            <input type="text" name="ponomor" value="{{$purchasing->purchasing +1}}" class="form-control" placeholder="Tambah Suppplier" hidden>

                        <div class="form-group row">
                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nama Supplier</label>

                                <input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" type="text" name="supplier" id="inputserch" class="form-control" placeholder="Tambah Suppplier">
                                <button type="button" class="btn btn-default" data-toggle="modal"
                                    data-target="#modal-popup"><i class="fa fa-plus"></i></button>

                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Email</label>
                                <div class="input-group-prepend">
                                </div>
                                <input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="email" type="email" class="form-control" name="email"
                                    placeholder="supplier@xxxxxx" required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">NPWP</label>
                                <input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="npwp" type="text" class="form-control" name="npwp"
                                    placeholder="1111.xxxx.xxxx" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 font-weight-bold col-form-label">Address</label>
                            <div class="col-sm-12">
                                <textarea style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" name="addr" id="addr" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed "></div>
                        <div class="form-group row ">
                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Category</label>

                                <input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" type="text" class="form-control" name="category" placeholder="" required>
                            </div>

                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nama Item</label>

                                <input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" type="text" class="form-control"  placeholder="Tambah Data Item"
                                    readonly>
                                <button type="button" class="btn btn-default" data-toggle="modal"
                                    data-target="#modal-popup1"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        {{-- Detail Barang --}}
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                        <h4 class="h4">Detail Item Barang</h4>
                                    {{-- <div class="card-body"> --}}
                                        <div class="table-responsivemobile">
                                            <table  class="tablemobile" id="tablelistproduk" style="font-size:14px">
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
                                <button {{-- href="{{route('Purchasing Cetak',$purchasing->purchasing)}}" --}} class="btn btn-primary btn-lg" type="submit">Save </button>
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
    <div role="document" class="modal-dialog" style="max-width:50%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title"> Input Purchasing Item </h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="target" action="" method="POST" enctype="multipart/form-data">
                    <div class="input-group col-sm-8">
                        <label class="col-sm-12 font-weight-bold col-form-label">Nama Item</label>
                        <div class="input-group-prepend">
                            <span  class="input-group-text"><i class="fa fa-"></i></span>
                        </div>
                        <input  type="text"  class="typeahead form-control" id="nama_item" name="nama_item" placeholder="" required>
                    </div>
                    <div class="input-group col-sm-8">
                        <label class="col-sm-12 font-weight-bold col-form-label">Harga</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-"></i></span>
                        </div>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="" required>
                    </div>
                    <div class="input-group col-sm-8">
                        <label class="col-sm-12 font-weight-bold col-form-label">Quantity</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-"></i></span>
                        </div>
                        <input type="number" class="form-control" id="qty" name="qty" placeholder="" required>
                    </div>
                    <div class="input-group col-sm-8">
                        <label class="col-sm-12 font-weight-bold col-form-label">Diskon</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-"></i></span>
                        </div>
                        <input type="number" class="form-control" id="diskon" name="diskon" placeholder="" required>
                    </div>
                    <div class="input-group col-sm-8">
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

<!-- modal struk coding cadangan -->
{{-- <div id="modal-struk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog" style="max-width:50%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel"  class="modal-title">Invoice Purchasing Order</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div id="isi_sturk">
                    <div class="card" >

                    <div class="card-body">
                        <table id="tablelistproduk" class="table PrintPos">
                            <img class="card-img-top img-responsive" weight="10px" height="20px" src="{{url('/storage/icon' , $setting->data->images)}}" alt="Card image cap">
                            <h4 class="card-title text-center">Terima Kasih Telah Menggunakan Jasa {{$setting->data->nama}}</h4>
                             <p class="card-text">{{$setting->data->prov}} , {{$setting->data->kab}} , {{$setting->data->kec}}, {{$setting->data->kel}} - {{$setting->data->tlp}} / {{$setting->data->hp}}</p>
                          <thead>
                            <th>Nama Item</th>
                            <th>Harga</th>
                            <th>Diskon</th>

                          </thead>
                          <tbody id="body_struk">

                          </tbody>
                          <tfoot id="cetak_total">
                            <tr>
                              <td>Total Belanja :</td>
                              <td></td>
                              <td id="print_total"></td>
                            </tr>
                            <tr>
                              <td>Bayar :</td>
                              <td></td>
                              <td id="print_bayar"></td>
                            </tr>
                            <tr>
                              <td>Kembali :</td>
                              <td></td>
                              <td id="print_kembali"></td>
                            </tr>
                          </tfoot>
                        </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
{{-- End modal struk --}}
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
    $(document).ready(function () {
        var no_order ="anjay mabar";

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
                    $('#email').val(data[2]);
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
            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" type="text" class="form-control" id="nama_item" name="nama_item[]" value="'+namai+'" readonly/></td>' +
            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="harga" name="harga[]" value="'+harga+'" readonly /></td>' +
            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="qty"   data-price=""  data-key=""  value="'+qty+'"   class="quantityTxt form-control" type="number"  name="qty[]" readonly></td>' +
            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="diskon"  data-price="" data-key="" value="'+diskon+'"  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]" readonly></td>' +
            '<td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="satuan" value="'+satuan+'"  class="totalprice form-control" type="text"  name="satuan[]" readonly/></td>' +
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

    $(document).ready(function(){
        var path = "{{route('autocomplete')}}";
        $('input.typeahead').typeahead({
            source:  function (query, process) {

            return $.get(path, { term: query }, function (data) {
            console.log(data);
            return process(data);


        });
    }
        });



    });


</script>

@stop
