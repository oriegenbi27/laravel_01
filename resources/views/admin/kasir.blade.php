<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Kasir</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/plugins/switchery/switchery.css')}}" rel="stylesheet">
    <link href="{{asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/css/buttons.dataTables.min.css')}}">
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('assets/css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/plugins/codemirror/ambiance.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <style>
        .glyphicon.fa{
            font-family: 'Glyphicons Halflings';
        }

    </style>
    @section('css') @show

</head>

<body class="fixed-sidebar no-skin-config full-height-layout">

<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="{{ Request::is('kasir') ? 'active' : '' }}"><a href="{{route('Kasir index')}}"><i class="fa fa-pie-chart"></i> <span class="nav-label">Kasir</span>  </a> </li>
                <li class="{{ Request::is('kasir/penjualan') ? 'active' : '' }}"><a href="{{route('Kasir penjualan')}}"><i class="fa fa-pie-chart"></i> <span class="nav-label">Penjualan</span>  </a> </li>
                <li class="{{ Request::is('kasir/laporan') ? 'active' : '' }}"><a href="{{route('Kasir laporan')}}"><i class="fa fa-pie-chart"></i> <span class="nav-label">Laporan</span>  </a> </li>
                <li class="{{ Request::is('kasir/penjualan') ? 'active' : '' }}"><a href="metrics.html"><i class="fa fa-pie-chart"></i> <span class="nav-label">Absensi</span>  </a> </li>
                <li class="{{ Request::is('kasir/penjualan') ? 'active' : '' }}"><a href="metrics.html"><i class="fa fa-pie-chart"></i> <span class="nav-label">Pengaturan</span>  </a> </li>
                <li class="{{ Request::is('kasir/penjualan') ? 'active' : '' }}"><a href="metrics.html"><i class="fa fa-pie-chart"></i> <span class="nav-label">Belanja</span>  </a> </li>
                <li class="{{ Request::is('kasir/penjualan') ? 'active' : '' }}"><a href="metrics.html"><i class="fa fa-pie-chart"></i> <span class="nav-label">Kunci Kasir</span>  </a> </li>
                <li class="{{ Request::is('kasir/penjualan') ? 'active' : '' }}"><a href="metrics.html"><i class="fa fa-pie-chart"></i> <span class="nav-label">Buka Kasir</span>  </a> </li>
                <li class="{{ Request::is('kasir/penjualan') ? 'active' : '' }}"><a href="metrics.html"><i class="fa fa-pie-chart"></i> <span class="nav-label">Log out</span>  </a> </li>
               
            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </nav>
            </div>
            @yield('content')
            <!-- <div class="wrapper wrapper-content animated fadeInRight">
            </div> -->
            <div class="footer">
                <div class="float-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Example Company &copy; 2014-2018
                </div>
            </div>
        </div>
</div>
<!-- Mainly scripts -->
<script src="{{asset('assets/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/switchery/switchery.js')}}"></script>

<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.js')}}"></script>

<script src="{{asset('assets/js/plugins/fullcalendar/moment.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/js/plugins/daterangepicker/daterangepicker.js')}}"></script>

<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/tables-datatable.js')}}"></script> 
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/fnReloadAjax.js')}}"></script> 
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/buttons.print.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{asset('assets/js/inspinia.js')}}"></script>
<script src="{{asset('assets/js/plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('assets/js/custome.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr/toastr.min.js')}}"></script>
@include('sweetalert::alert')
@section('js') @show
</body>

</html>
