@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Tables</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Karyawan List </strong>
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
                    <h5>Data Karywan</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover data-karywan" style="width:100%">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Nama</th>
                                    <th>Email</th>
                                    <th>No Telp</th>
                                    <th data-hide="all">No HP</th>
                                    <th data-hide="all">NPWP</th>
                                    <th data-hide="all">Provinsi </th>
                                    <th data-hide="all">Kota / Kabupaten</th>
                                    <th data-hide="all">Kecamatan</th>
                                    <th data-hide="all">Kelurahan</th>
                                    <th data-hide="all">Kode Pos</th>
                                    <th data-hide="all">Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php for($i=0;$i<=15;$i++){?>
                                <tr class="gradeA">
                                    <td>Trident</td>
                                    <td>AOL browser (AOL desktop)</td>
                                    <td>Win XP</td>
                                    <td class="center">6</td>
                                    <td class="center">A</td>
                                    <td class="center">A</td>
                                    <td class="center">A</td>
                                    <td class="center">A</td>
                                    <td class="center">A</td>
                                    <td class="center">A</td>
                                    <td class="center">A</td>
                                    <td class="center">A</td>
                                </tr>
                            <?php }?>
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
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/css/buttons.dataTables.min.css')}}">
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
        $(document).ready(function(){
            $('.data-karywan').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgtip',
                buttons: [
                    {text: '<i class="fa fa-plus-square"></i>',className:'tambah btn-primary btn-sm ladda-button',titleAttr:'Tambah Data' ,
                    init: function(api, node, config) { $(node).removeClass('dt-button')},
                    action: function ( e, dt, node, config ) {
                        	
                    }
                    },
                        { extend: 'copy', className: 'btn-primary btn-sm ladda-button',titleAttr:'Copy Data' ,text: '<i class="fa fa-clone" aria-hidden="true"></i>',init: function(api, node, config) { $(node).removeClass('dt-button')} },
                        { extend: 'csv', className: 'btn-primary btn-sm ladda-button',titleAttr:'Save To CSV',text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',init: function(api, node, config) { $(node).removeClass('dt-button')} },
                        { extend: 'print', className: 'btn-primary btn-sm ladda-button',titleAttr:'Print Data',text: '<i class="fa fa-print" aria-hidden="true"></i>',init: function(api, node, config) { $(node).removeClass('dt-button')} },
                        
                    ],

            });

        });

    </script>
@stop