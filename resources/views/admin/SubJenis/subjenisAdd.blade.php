@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Sub Jenis Barang Add</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('List Jenis Barang')}}">Sub Jenis Barang</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Sub Jenis Barang Add</strong>
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
                    <h5>Sub Jenis <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{route('List Jenis Barang')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="hr-line-dashed border"></div>
                        <div class="form-group row">
                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nama Sub Jenis Barang</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-balance-scale"></i></span>
                                </div>
                                <input type="text" class="form-control" name="nama" placeholder="Nama Sub Jenis Barang" required>
                            </div>

                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Code Sub Jenis Barang</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-file-text"></i></span>
                                </div>
                                <input type="text" class="form-control" name="code" placeholder="Code Sub Jenis Barang" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 font-weight-bold col-form-label">Keterangan</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="keterangan" id="" cols="30" rows="10"></textarea>
                                <span class="form-text m-b-none"></span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-danger btn-lg" type="reset">Cancel</button>
                                <button class="btn btn-primary btn-lg" type="submit">Save </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
