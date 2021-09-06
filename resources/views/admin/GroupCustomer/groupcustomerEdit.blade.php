@extends('admin.master')
@section('assets')
@endsection
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Group Customer Edit</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('List Group Customer')}}">Group Customer</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Group Customer Edit</strong>
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
                    <h5>Group Customer <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{route('List Group Customer')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                
                <div class="ibox-content border ">
                    <form action="" method="POST" enctype="multipart/form-data"> 
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group has-success col-sm-12">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>Code</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                    <input style="height: 1.6rem;" value="{{$GroupCustomer->data->code}}" autocomplete="off" type="text" class="form-control" name="codegc" required>
                                    </div>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-12">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>Nama</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                    <input style="height: 1.6rem;" value="{{$GroupCustomer->data->nama}}" autocomplete="off" type="text" class="form-control" name="nama"  required>
                                    </div>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-12">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>Level</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                    <input style="height: 1.6rem; background-color: transparent;" value="{{$GroupCustomer->data->level}}" autocomplete="off" type="number" min="{{$GroupCustomer->data->level+1}}" max="99" class="form-control" name="level"  readonly>
                                    </div>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-12">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>Diskon</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                    <input style="height: 1.6rem;" value="{{$GroupCustomer->data->diskon}}" autocomplete="off" type="number" min="0" max="100" class="form-control" name="diskon"  required>
                                    </div>
                                </div>
                                &nbsp;
                                <div class="input-group has-success col-sm-12">
                                    <div class="col-sm-4 text-sm-left">
                                        <dt>Keterangan</dt>
                                    </div>
                                    <textarea class="form-control" name="keterangan" id="" >{{$GroupCustomer->data->keterangan}}</textarea> 
                                </div>
                                &nbsp;
                                <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-danger btn-lg" type="reset">Cancel</button>
                                <button class="btn btn-primary btn-lg" type="submit">Save </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop