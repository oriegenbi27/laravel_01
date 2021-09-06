@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Sumber Sales Edit</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/sumber_sales')}}">Sumber Sales</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Sumber Sales Edit</strong>
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
                    <h5>Satuan <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{url('/sumber_sales')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="{{url('/edit_sumber_sales' , $SumberSales->data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="hr-line-dashed border"></div>
                        <div class="form-group row">
                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nama Jenis Barang</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-balance-scale"></i></span>
                                </div>
                                <input type="text" class="form-control" name="nama" value="{{$SumberSales->data->nama}}" placeholder="Nama Satuan" required>
                            </div>

                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Code Satuan</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-file-text"></i></span>
                                </div>
                                <input type="text" class="form-control" name="code" value="{{$SumberSales->data->code}}" placeholder="Code Satuan" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 font-weight-bold col-form-label">Keterangan</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="keterangan" id="" cols="30" rows="10">{{$SumberSales->data->keterangan}}</textarea>
                                <span class="form-text m-b-none">A block of help text that breaks onto a new line and
                                    may extend beyond one line.</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <input type="hidden" name="id" value="{{$SumberSales->data->id}}">
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
