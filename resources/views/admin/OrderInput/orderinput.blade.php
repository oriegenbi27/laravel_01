@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Order</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Data Order List </strong>
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
                    <h5>Data Order</h5>
                </div>
                <div class="ibox-tools">

                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover data-karywan display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th data-toggle="true">sumber_sales</th>
                                    <th>nama</th>
                                    <th>No Telp</th>
                                    <th data-hide="all">kode pos</th>
                                    <th data-hide="all">address</th>
                                    <th data-hide="all">pembayaran </th> 
                                    <th data-hide="all">ket_pembayaran</th>
                                    <th data-hide="all">ekspedisi</th>
                                    <th data-hide="all">total_bayar</th>
                                    <th data-hide="all">ongkir</th>
                                    <th data-hide="all">grand_total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($OrderInput->data as $row)
                                <tr>
                                    <td>{{ $row-> sumber_sales }}</td>
                                    <td>{{ $row-> nama }}</td>
                                    <td>{{ $row-> no_tlp }}</td>
                                    <td>{{ $row-> kode_pos }}</td>
                                    <td>{{ $row-> addr }}</td>
                                    <td>{{ $row-> pembayaran }}</td>
                                    <td>{{ $row-> ket_pembayaran }}</td>
                                    <td>{{ $row-> ekspedisi }}</td>
                                    <td>Rp.{{ $row-> sub_total }}</td>
                                    <td>{{ $row-> ongkir }}</td>
                                    <td>Rp.{{ $row-> grand_total }}</td>
                                    <td>
                                        <a href="{{route('Edit Order Input' , $row -> id)}}"><i
                                                class="fa fa-pencil text-navy" title="EDIT"></i></a> &nbsp; &nbsp;
                                        &nbsp;
                                        <a href="{{route('Delete Order Input' , $row -> id)}}"><i
                                                class="fa fa-trash text-danger" title="DELETE"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.data-karywan').DataTable({
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
                        window.location = "{{route('Add Order Input')}}"
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
</script>
@stop
