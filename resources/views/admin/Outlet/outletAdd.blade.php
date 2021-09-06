@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Add New Outlet</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/outlet')}}">Outlet</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add</strong>
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
                    <h5>Insert Data Outlet <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn "  href="{{url('/produk')}}" title="back">
                           <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- List Input bagian kiri --}}
                            <div class="col-lg-6">
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Nama Outlet</dt> 
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="text" class="form-control"
                                        name="nama" id="nama"  required>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Password</dt> 
                                    </div>
                                    <input style="height: 1.6rem;" autocomplete="off" type="password" class="form-control"
                                        name="password" id="password"  required>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right ">
                                        <dt>Alamat</dt>
                                    </div>
                                    <textarea class="form-control" name="alamat" id="alamat"></textarea>
                                </div>
                                &nbsp; 
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Tanggal Awal</dt> 
                                    </div>
                                    <input hidden name="harga1" id="harga1">
                                    <input style="height: 1.6rem;"  name="awal" id="awal" type="date" class="form-control" >
                                </div>
                                &nbsp; 
                                <div class="input-group has-success col-sm-8">
                                    <div class="col-sm-5 text-sm-right">
                                        <dt>Tanggal Akhir</dt> 
                                    </div>
                                    <input hidden name="harga1" id="harga1">
                                    <input  style="height: 1.6rem;"  name="akhir" id="akhir" type="date" class="form-control">
                                </div>
                                &nbsp; 
                            </div> 
                            
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
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
<!-- Typehead -->
<script src="{{asset('assets/js/plugins/typehead/bootstrap3-typeahead.min.js')}}"></script>
<script>
 
</script>
@stop

