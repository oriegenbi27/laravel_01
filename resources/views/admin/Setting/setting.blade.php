@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tables Setting</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Setting </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

        <div class="row m-t-lg">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Detail Perusahaan</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Setting Perushaan</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Setting Penomeran Transaksi</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-4">Setting Nomer Master</a></li>
                    </ul>
                    <div class="tab-content">

                        <!-- tab1 -->
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <strong>Note :</strong>

                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet
                                    mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm
                                    of
                                    existence in this spot, which was created for the bliss of souls like mine.</p>


                                <div class="continer">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{url('/storage/icon' , $data->data->images)}}"
                                                class="img-thumbnail " alt="">
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="list-group">
                                                <li class="list-group-item"><i class="fa fa-address-book"></i> Nama
                                                    Perushaan</li>
                                                <li class="list-group-item"><i class="fa fa-envelope-square"></i> Email
                                                </li>
                                                <li class="list-group-item"><i class="fa fa-phone-square"></i> No Telpon
                                                </li>
                                                <li class="list-group-item"><i class="fa fa-mobile"></i> No Hp</li>
                                                <li class="list-group-item"><i class="fa fa-id-card"></i> NPWP</li>
                                                <li class="list-group-item"><i class="fa fa-map-marker"></i> Alamat
                                                    Lengkap</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="list-group">
                                                <li class="list-group-item">{{$data->data->nama}}</li>
                                                <li class="list-group-item">{{$data->data->email}}</li>
                                                <li class="list-group-item">{{$data->data->tlp}}</li>
                                                <li class="list-group-item">{{$data->data->hp}}</li>
                                                <li class="list-group-item">{{$data->data->npwp}}</li>
                                                <li class="list-group-item">{{$data->data->addr}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- tab2 -->
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <strong>Note :</strong>

                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet
                                    mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm
                                    of
                                    existence in this spot, which was created for the bliss of souls like mine.</p>

                                <form action="#" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="hr-line-dashed border"></div>
                                    <div class="form-group row">
                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Nama
                                                Perusahaan</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-address-book"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="nama"
                                                placeholder="Nama Perusahaan" required>

                                        </div>

                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Email
                                                Perusahaan</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fa fa-envelope-square"></i></span>
                                            </div>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="perushaan@email.com" required>
                                        </div>

                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Nomer
                                                Teplon</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                                            </div>

                                            <input type="number" class="form-control" name="tlp" placeholder="021xxxxx"
                                                required>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed "></div>
                                    <div class="form-group row ">

                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Nomer HP</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                            </div>
                                            <input type="number" class="form-control" name="hp" placeholder="08xxxxx"
                                                required>
                                        </div>

                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">NPWP</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                            </div>
                                            <input type="number" class="form-control" data-mask="999-99-999-9999-9"
                                                name="npwp" required>
                                        </div>

                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Kota /
                                                Kecamatan</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                                            </div>
                                            <input type="text" class="typeahead_3 form-control" name="prov"
                                                placeholder="Provinsi" required>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row ">
                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Kode Pos</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
                                            <input type="number" class="form-control" name="kode_pos"
                                                placeholder="12345" required>
                                        </div>

                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Longtitude</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="longlat" id="longlat"
                                                placeholder="loremipsum" required>
                                        </div>

                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">jam
                                                Oprasional</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
                                            <input type="time" class="form-control" name="time" id="time"
                                                placeholder="loremipsum" required>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row ">
                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Alamat
                                                Lengkap</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="addr"
                                                placeholder="loremipsuum" required>
                                        </div>

                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Tipe Bisnis</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="tipe_bisnis" id="tipe_bisnis"
                                                placeholder="loremipsum" required>
                                        </div>

                                        <div class="input-group col-sm-4">
                                            <label class="col-sm-12 font-weight-bold col-form-label">Logo
                                                Perushaan</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
                                            <input type="file" class="form-control" name="icon" id="icon"
                                                placeholder="loremipsum" required>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed border"></div>

                                    <div class="form-group row">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-danger btn-lg" type="reset">Cancel</button>
                                            <button class="btn btn-primary btn-lg" type="submit">Save </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- tab3 -->
                        <div id="tab-4" class="tab-pane">
                            <div class="panel-body">
                                <strong>Note :</strong>

                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet
                                    mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm
                                    of
                                    existence in this spot, which was created for the bliss of souls like mine.</p>

                                <form action="#" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="hr-line-dashed border"></div>
                                    <div class="form-group row">
                                        <label class="col-sm-12 font-weight-bold col-form-label">Format No Supplier
                                            :</label>
                                        <div class="input-group col-sm-2">
                                            <select class="form-control" name="" id="">
                                                <option value="">SP</option>
                                                <option value="">SP</option>
                                                <option value="">SP</option>
                                                <option value="">SP</option>
                                            </select>
                                        </div>

                                        <div class="input-group col-sm-1">
                                            <select class="form-control" name="" id="">
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </div>

                                        <div class="input-group col-sm-2">
                                            <select class="form-control" name="" id="">
                                                <option value="">CNT</option>
                                                <option value="">CNT</option>
                                                <option value="">CNT</option>
                                                <option value="">CNT</option>
                                            </select>
                                        </div>

                                        <div class="input-group col-sm-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Digit CNT </span>
                                            </div>
                                            <input class="form-control" type="number" name="" placeholder="">
                                        </div>
                                        
                                        <div class="input-group col-sm-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Nomer Terakhir</span>
                                            </div>
                                            <input class="form-control" type="number" name="" placeholder="">
                                        </div>

                                    </div>
                                    <div class="hr-line-dashed border"></div>
                                    <div class="form-group row">
                                        <label class="col-sm-12 font-weight-bold col-form-label">Format No Supplier
                                            :</label>
                                        <div class="input-group col-sm-2">
                                            <select class="form-control" name="" id="">
                                                <option value="">PL</option>
                                                <option value="">PL</option>
                                                <option value="">PL</option>
                                                <option value="">PL</option>
                                            </select>
                                        </div>

                                        <div class="input-group col-sm-1">
                                            <select class="form-control" name="" id="">
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </div>

                                        <div class="input-group col-sm-2">
                                            <select class="form-control" name="" id="">
                                                <option value="">CNT</option>
                                                <option value="">CNT</option>
                                                <option value="">CNT</option>
                                                <option value="">CNT</option>
                                            </select>
                                        </div>

                                        <div class="input-group col-sm-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Digit CNT </span>
                                            </div>
                                            <input class="form-control" type="number" name="" placeholder="">
                                        </div>
                                        
                                        <div class="input-group col-sm-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Nomer Terakhir</span>
                                            </div>
                                            <input class="form-control" type="number" name="" placeholder="">
                                        </div>

                                    </div>

                                    <div class="hr-line-dashed border"></div>
                                    <div class="form-group row">
                                        <label class="col-sm-12 font-weight-bold col-form-label">Format No Supplier
                                            :</label>
                                        <div class="input-group col-sm-2">
                                            <select class="form-control" name="" id="">
                                                <option value="">SL</option>
                                                <option value="">SL</option>
                                                <option value="">SL</option>
                                                <option value="">SL</option>
                                            </select>
                                        </div>

                                        <div class="input-group col-sm-1">
                                            <select class="form-control" name="" id="">
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </div>

                                        <div class="input-group col-sm-2">
                                            <select class="form-control" name="" id="">
                                                <option value="">CNT</option>
                                                <option value="">CNT</option>
                                                <option value="">CNT</option>
                                                <option value="">CNT</option>
                                            </select>
                                        </div>

                                        <div class="input-group col-sm-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Digit CNT </span>
                                            </div>
                                            <input class="form-control" type="number" name="" placeholder="">
                                        </div>
                                        
                                        <div class="input-group col-sm-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Nomer Terakhir</span>
                                            </div>
                                            <input class="form-control" type="number" name="" placeholder="">
                                        </div>

                                    </div>
                                    <!--  -->
                                    <div class="hr-line-dashed border"></div>

                                    <div class="form-group row">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-danger btn-lg" type="reset">Cancel</button>
                                            <button class="btn btn-primary btn-lg" type="submit">Save </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- tab4 -->
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
<!-- Typehead -->
<script src="{{asset('assets/js/plugins/typehead/bootstrap3-typeahead.min.js')}}"></script>
<script>
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