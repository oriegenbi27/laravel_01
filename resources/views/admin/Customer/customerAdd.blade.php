@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{$menu['title']}}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{$menu['url_back']}}">{{$menu['back']}}</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>{{$menu['title']}}</strong>
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
                    <h5>{{$menu['title']}} <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn "  href="{{$menu['url_back']}}" title="back">
                           <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="" method="POST">
                        @csrf
                        <div class="hr-line-dashed border"></div>
                        <div class="form-group row">
                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nama {{$menu['back']}}</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-address-book"></i></span>
                                </div>
                                <input type="text" class="form-control" name="nama" placeholder="Nama {{$menu['back']}}"
                                    required>

                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Email {{$menu['back']}}</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope-square"></i></span>
                                </div>
                                <input type="email" class="form-control" name="email" placeholder="{{$menu['back']}}@email.com"
                                    required>
                            </div>

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Nomer Teplon</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                                </div>

                                <input type="number" class="form-control" name="tlp" placeholder="021xxxxx" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed "></div>
                        <div class="form-group row ">

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

                            <div class="input-group col-sm-4">
                                <label class="col-sm-12 font-weight-bold col-form-label">Kota / Kecamatan</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" id="typeahead_3" class="form-control" name="prov" placeholder="Provinsi" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                       
                        <div class="hr-line-dashed border"></div>
                        <div class="form-group row">
                            <label class="col-sm-12 font-weight-bold col-form-label">Alamat Lengkap</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="addr" id="" cols="10" rows="5"></textarea>
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

@section('js')
 <!-- Typehead -->
 <script src="{{asset('assets/js/plugins/typehead/bootstrap3-typeahead.min.js')}}"></script>


<script>
    $(document).ready(function(){
        $('#typeahead_3').typeahead({
            source: [
                {"name": "Banten/kota Tangerang/Jatiuwung/Manis Jaya"},
                {"name": "Jakarta/Jakarta Barat/kecamatan/kelurahan"},
                {"name": "Jawa Barat/Bandung/kecamatan/kelurahan"},
                {"name": "Jawa Tengah/Jogjakarta/kecamatan/kelurahan"}
            ]
        });


    });
</script>
@stop