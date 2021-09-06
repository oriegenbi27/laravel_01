@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Bank Edit</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/bank')}}">Bank</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Bank Edit</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
                <div class="col-lg-12 " >
                    <div class="ibox ">
                        <div class="ibox-title bg-primary" >
                            <h5>Bank <small></small></h5>
                            <div class="ibox-tools"></div>
                        </div>
                        <div class="ibox-content">
                            <form action="{{ url('/edit_bank' , $bank->data->id)}}" method="POST">
                                @csrf

                                <div class="hr-line-dashed"></div>
                                <div class="form-group row ">
                                    <div class="input-group col-sm-3" >
                                        <label class="col-sm-12 font-weight-bold col-form-label">Code</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-book"></i></span>
                                        </div>
                                        <input  type="number" class="form-control" value="{{$bank->data->code}}" name="code" placeholder="002" required>
                                    </div>
                                    <div class="input-group col-sm-4">
                                        <label class="col-sm-12 font-weight-bold col-form-label">Cabang</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-bank"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$bank->data->cabang}}" name="cabang" placeholder="BRI" required>
                                    </div>
                                    <div class="input-group col-sm-3">
                                        <label class="col-sm-12 font-weight-bold col-form-label">Nomor Rekening</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                        </div>
                                        <input type="number" class="form-control" value="{{$bank->data->no_rek}}" name="no_rek" placeholder="882193212" required>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row ">
                                    <div class="input-group col-sm-3">
                                        <label class="col-sm-12 font-weight-bold col-form-label">id owner</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="number" class="form-control" value="{{$bank->data->id_owner}}" data-mask="999-99-999-9999-9" name="id_owner" placeholder="9210312" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="col-sm-12 font-weight-bold col-form-label">Keterangan</label>
                                        <textarea class="form-control" name="keterangan" id=""  >{{$bank->data->keterangan}}</textarea>
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

