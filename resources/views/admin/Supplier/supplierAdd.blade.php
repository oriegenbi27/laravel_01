@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Supplier Add</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/supplier')}}">Supplier</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Supplier Add</strong>
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
                    <h5>Supplier <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn "  href="{{url('/supplier')}}" title="back">
                           <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="" method="POST">
                        @csrf
                        <div class="hr-line-dashed border"></div>
                        <div class="form-group row">
                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nama Supplier</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-address-book"></i></span>
                                </div>
                                <input type="text" class="form-control" name="nama" placeholder="Nama Supplier"
                                    required>

                            </div>

                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Email Supplier</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope-square"></i></span>
                                </div>
                                <input type="email" class="form-control" name="email" placeholder="supplier@email.com"
                                    required>
                            </div>
                        </div>
                        <div class="hr-line-dashed "></div>
                        <div class="form-group row ">
                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nomer Teplon</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                                </div>

                                <input type="number" class="form-control" name="tlp" placeholder="021xxxxx" required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nomer HP</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                </div>
                                <input type="number" class="form-control" name="hp" placeholder="08xxxxx" required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">NPWP</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                </div>
                                <input type="number" class="form-control" data-mask="999-99-999-9999-9" name="npwp"
                                    required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row ">
                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Provinsi</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                </div>
                                <input type="text" class="form-control" name="prov" placeholder="Provinsi" required>
                            </div>

                            <div class="input-group col-sm-6">
                                <label class="col-sm-12 font-weight-bold col-form-label">Kota / Kabupaten</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                </div>
                                <input type="text" class="form-control" name="kab" placeholder="Kota / Kabupaten"
                                    required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Kecamatan</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                </div>
                                <input type="text" class="form-control" name="kec" placeholder="Kecamtan" required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Kelurahan</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                </div>
                                <input type="text" class="form-control" name="kel" placeholder="Kecamtan" required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Kode Pos</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                </div>
                                <input type="text" class="form-control" name="kode_pos" placeholder="15022" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed border"></div>
                        <div class="form-group row">
                            <label class="col-sm-12 font-weight-bold col-form-label">Address</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="addr" id="" cols="30" rows="10"></textarea>
                                <span class="form-text m-b-none">A block of help text that breaks onto a new line and
                                    may extend beyond one line.</span>
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