@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Prefensi</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('Preferensi ERP')}}">Prefensi</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Prefensi Add</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox border">
                <div class="ibox-title">
                    <h5>Prefensi <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn "  href="{{route('Preferensi ERP')}}" title="back">
                           <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Tipe Akun:</dt> </div>
                            <div class="col-sm-8 text-sm-left"><dd class="mb-1">
                            <div class="form-group row has-success"><div class="col-sm-10">
                                <select class="tipeaccunt form-control" name="tipeakun" style="border-top:none;border-left:none;border-right:none;">
                                    <option></option>
                                    @foreach($data->data as $row)
                                    <?php
                                      $nama = '';
                                      $kode = '';
                                      if(empty($row->akun_induk)){
                                        $nama = $row->nama;
                                        $kode = $row->kode_perkiraan;
                                      }
                                    ?>
                                    <option value="{{$kode}}">{{$nama}}</option> 
                                    @endforeach
                                    <!-- <option value="Piutang Usaha">Piutang Usaha</option>
                                    <option value="Persediaan">Persediaan</option>
                                    <option value="Aset Lancar Lainnya">Aset Lancar Lainnya</option>
                                    <option value="Aset Tetap">Aset Tetap</option>
                                    <option value="Akumulasi Penyusutan">Akumulasi Penyusutan</option>
                                    <option value="Aset Lainnya">Aset Lainnya</option>
                                    <option value="Hutang Usaha">Hutang Usaha</option>
                                    <option value="Kewajiban Jangka Pendek">Kewajiban Jangka Pendek</option>
                                    <option value="Kewajiban Jangka Panjang">Kewajiban Jangka Panjang</option>
                                    <option value="Modal">Modal</option>
                                    <option value="Pendapatan">Pendapatan</option>
                                    <option value="Beban Pokok Penjualan">Beban Pokok Penjualan</option>
                                    <option value="Beban">Beban</option>
                                    <option value="Beban Lainnya">Beban Lainnya</option>
                                    <option value="Pendapatan Lainnya">Pendapatan Lainnya</option> -->
                                 </select>
                                    
                                </div>    
                                </div>    
                        </dd> </div>
                        </dl>

                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Nama Preferensi Finance:</dt> </div>
                            <div class="col-sm-8 text-sm-left"><dd class="mb-1" id="preferensiname">
                            <div class="form-group row has-success"><div class="input-group col-sm-10">
                                <input type="text" class="form-control" name="nama[]" style="none;border-right:none;height: 1.6rem;">
                                <div class="input-group-prepend">
                                    <span class="btn input-group-text button-add" style="background: transparent;border-color:#0288d1;border-left: none;border-radius: 0px 4px 4px 0px;height: 1.6rem;">
                                    <i class="fa fa-plus"></i></span></div>
                                </div></div>
                        </dd> </div>
                        </dl>


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
        <div class="col-lg-4">
        </div>
    </div>
</div>

@endsection
@section('css')
<link href="{{asset('assets/css/plugins/select2/select2.min.css')}}" rel="stylesheet">   
@stop
@section('js')
<script src="{{asset('assets/js/plugins/select2/select2.full.min.js')}}"></script>
<script>
$(document).ready(function () {
    $(".tipeaccunt").select2({
                placeholder: "Select Tipe Akun",
                allowClear: true
            });
});

    
$(document).on("click", "#savedata", function (e) { 
	$("#formbiodata").submit();
});	    
var preference=0;
$(document).on("click", ".button-add", function (e) { 
    let tipe=$(".tipeaccunt").val();
   if(tipe==""){
       alert('Silahkan pilih tipe terlibih dahulu');
       return false;
   }else{
        let html="";
            html='<div id="preference'+preference+'" class="form-group row has-success"><div class="input-group col-sm-10">'+
                                    '<input type="text" class="form-control" name="nama[]" style="none;border-right:none;height: 1.6rem;">'+
                                    '<div class="input-group-prepend">'+
                                    '<span  id="preferencebtn'+preference+'" class="btn input-group-text button-remove" data-id="'+preference+'" style="background: transparent;border-color:#0288d1;border-left: none;border-radius: 0px 4px 4px 0px;height: 1.6rem;">'+
                                        '<i id="preferencebtn'+preference+'" class="fa fa-minus"></i></span></div>'+
                                    '</div></div>';
        $("#preferensiname").append(html);
        preference++;
    }
});	

$(document).on("click", ".button-remove", function (e) { 
   let id=this.id;
   let btn=$("#"+id).data('id'); 
   $("#preference"+btn).remove();


});
</script>

@stop
