@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Return Purchasing Order</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>

        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-4">

            <div class="ibox-content border ">
                <form action="{{url('warehouse/search')}}" method="POST" enctype="multipart/form-data">
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-right">
                            <dt>PO:</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <div class="form-group row has-success">
                                    <div class="input-group col-sm-10">
                                        @csrf
                                        @if (empty($purchasing))
                                        <input type="text" class="typeahead form-control" value="" name="ponomor"
                                            style="none;border-right:none;height: 1.6rem;" required>
                                        @else
                                        <input type="text" class="typeahead form-control"
                                            value="{{$purchasing->data->id}}" name="ponomor"
                                            style="none;border-right:none;height: 1.6rem;" required>

                                        <input id="status" value="{{$purchasing->data->status}}" hidden>
                                        @endif

                                        <div class="input-group-prepend">
                                            <button id="cari" class="btn input-group-text button-add" type="submit"
                                                style="background: transparent;border-color:#0288d1;border-left: none;border-radius: 0px 4px 4px 0px;height: 1.6rem;">
                                                <i class="fa fa-search"></i> </button></div>

                                    </div>
                         </div>
                </form>
                </dd>
            </div>
            </dl>
            <form action="{{route('Warehouse ERP')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (empty($purchasing))
                <input type="text" class="typeahead form-control" value="" name="ponomor1"
                    style="none;border-right:none;height: 1.6rem;" required hidden>
                @else
                <input type="text" class="typeahead form-control"
                    value="{{$purchasing->data->id}}" name="ponomor2"
                    style="none;border-right:none;height: 1.6rem;" required hidden>
                @endif
                <dl class="row mb-0">
                    <div class="col-sm-4 text-sm-right">
                        <dt>Tipe:</dt>
                    </div>
                    <div class="col-sm-8 text-sm-left">
                        <dd class="mb-1">
                            <div class="form-group row has-success">
                                <div class="col-sm-10">
                                    <select class="tipeaccunt form-control" name="tipe"
                                        style="border-top:none;border-left:none;border-right:none;">
                                        <option></option>
                                        <option value="IN">IN</option>
                                        <option value="OUT">OUT</option>
                                    </select>

                                </div>
                            </div>
                        </dd>
                    </div>
                </dl>

                <dl class="row mb-0">
                    <div class="col-sm-4 text-sm-right">
                        <dt>Akun:</dt>
                    </div>
                    <div class="col-sm-8 text-sm-left">
                        <dd class="mb-1">
                            <div class="form-group row has-success">
                                <div class="col-sm-10">
                                    <select class="tipeaccunt form-control" name="akun"
                                        style="border-top:none;border-left:none;border-right:none;">
                                        <option></option>
                                        <option value="Pendapatan">Pendapatan</option>
                                        <option value="Pengeluaran">Pengeluaran</option>
                                        <option value="Beban">Beban</option>
                                        <option value="Persediaan">Persediaan</option>
                                        <option value="Piutang">Piutang</option>
                                        <option value="Utang">Utang</option>
                                    </select>

                                </div>
                            </div>
                        </dd>
                    </div>
                </dl>
                <dl class="row mb-0">
                    <div class="col-sm-4 text-sm-right">
                        <dt>Date:</dt>
                    </div>
                    <div class="col-sm-8 text-sm-left">
                        <dd class="mb-1">
                            <div class="form-group row has-success">
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" value="" name="date"
                                    style="border-radius: 4px;height: 1.6rem;">
                                    {{-- jika date diambil dari database purchasing --}}
                                    {{-- @if (empty($purchasing))
                                    <input type="text" class="form-control" value="" name="date"
                                        style="border-radius: 4px;height: 1.6rem;">
                                    @else
                                    <input type="text" class="form-control" value="{{$purchasing->data->created_at}}"
                                        name="date" style="border-radius: 4px;height: 1.6rem;">
                                    @endif --}}
                                </div>
                            </div>
                        </dd>
                    </div>
                </dl>


                <div class="form-group row">
                    <div class="col-sm-12 col-sm-offset-2">
                        <button class="btn btn-danger btn-lg" type="reset">Cancel</button>
                        <button class="btn btn-primary btn-lg" type="submit">Save </button>
                    </div>
                </div>

            {{-- </form> --}}
        </div>
    </div>
    <div class="col-lg-8">
        <div class="ibox-content border ">
            <div class="table-responsive">
                <div class="input-group"><input placeholder="Search" type="text" class="form-control form-control-sm">
                    <span class="input-group-append"> <button type="button" class="btn btn-sm btn-primary">Search
                        </button> </span></div>
                <table class="table table-striped">
                    <thead style="background-color:#fff;color:#565151;">
                        <tr>

                            <th>ID </th>
                            <th>PO Nomor</th>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Actual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($purchasing))
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @else
                        @foreach($purchasing->data->detailpurchasing as $detail)
                        <tr class="records" name="id" id="tr{{$detail->id}}" data-id="{{$detail->id}}">
                            <td><input  style="border-top:none;border-left:none;border-right:none; border-bottom:none; width:50px; background-color: transparent;" name="iddetails[]" value="{{$detail->id}}" readonly></td>
                            <td><input  style="border-top:none;border-left:none;border-right:none; border-bottom:none; width:50px; background-color: transparent;" name="idpurchasing[]" value="{{$detail->id_purchasing}}" readonly></td>
                            <td><input  style="border-top:none;border-left:none;border-right:none; border-bottom:none; width:50px; background-color: transparent;" name="namabrg[]" value="{{$detail->nama}}" readonly></td>
                            <td><input  style="border-top:none;border-left:none;border-right:none; border-bottom:none; width:50px; background-color: transparent;" name="qtybarang[]" value="{{$detail->qty}}" readonly></td>
                            <td><input  id="actual{{$detail->id}}" type="number"  data-key="{{$detail->id}}" min="0" max="{{$detail->qty}}" class="form-control" name="actual[]"
                                    style="max-width:100px;border-radius:4px;height: 1.6rem;"  ></td>
                            <td><input name="cek[]" id="cek{{$detail->id}}"  data-key="{{$detail->id}}" onchange="return cek(this)" class="checkbox_check" type="checkbox"></td>
                        </tr>

                        @endforeach

                        @endif
                    </form>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</div>

{{-- Start Pop data Purchasing Order --}}
<div id="modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog" style="max-width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title"> Detail Data Supplier </h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                        aria-hidden="true">×</span></button>
            </div>
            {{-- <div class="modal-body"> --}}
            {{-- <div class="text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item"><a href="#Original" class="nav-link show active"
                                    data-from="originalform" role="tab" data-toggle="tab">Data Supplier</a></li>
                        </ul>
                    </div>
                </div> --}}

            <div class="tab-content card-body no-padding" style="padding-bottom: 20px !important;">
                <div id="Original" class="tab-pane active">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable1" style="width: 100%;" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="10%">id</th>
                                            <th width="10%">Supplier</th>
                                            <th width="10%">NPWP</th>
                                            <th width="10%">Email</th>
                                            <th width="10%">category</th>
                                            <th style="text-align: center" width="50%">Alamat</th>
                                            <th>#</th>

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
            {{-- </div> --}}
        </div>
    </div>
</div>
{{-- End Pop data Purchasing Order  --}}

@endsection
@section('css')
<link href="{{asset('assets/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet"
    href="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/css/buttons.dataTables.min.css')}}">

@stop
@section('js')
<script src="{{asset('assets/js/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/typehead/bootstrap3-typeahead.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
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


<script>
    $(document).ready(function () {
        $(".tipeaccunt").select2({
            placeholder: "Select Tipe Akun",
            allowClear: true
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
                "url": "{{route('jsonpurchasing')}}",
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

    // Logic Cek Box
    function cek(e){
        let id=e.id;
        let key=$('#'+id).data('key');
            if($('#cek'+key).prop("checked") == true){
                $('#actual'+key).removeAttr('disabled');
            }
            else if($('#cek'+key).prop("checked") == false){
                $('#actual'+key).attr('disabled', 'disabled');
                $('#actual'+key).val(null);
            }

    }

    // Alert jika purchasing order sudah selesai atau status completed

        $('#cari').click(function(){

            // swal({
            //     title: "PO sudah selesai",
            //     text: "Silahkan input kembali no PO yang belum selesai"
            //     window.location.replace("http://stackoverflow.com");
            // });


        });



</script>

@stop
