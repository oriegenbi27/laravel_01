@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row">
            <div class="col-lg-9">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <a id="savedata" class="btn btn-white btn-xs float-right" >Save</a>
                                        <h2>Detail informasi karyawan</h2>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4" id="cluster_info">
                                <form id="formbiodata" action="" method="post" enctype='multipart/form-data'>
                                @csrf
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <span class="btn btn-outline-default btn-file btn-round" style="position: absolute;/*! background-color: #1976D2; */top: 20%;left: 90%;overflow: hidden;"><span class="fileinput-new btn btn-xs btn-primary"><i class="fa fa-camera"></i> Add Photo</span><span class="fileinput-exists"><span class="rounded-circle" style="font-size: 48px;background: #f3f3f4;"><i class="fa fa-camera"></i></span></span><input id="imagesphotojson"  type="file" ><input id="imagesphotojsn" name="images" type="file" ></span>
                                        <div class="fileinput-new thumbnail img-circle img-no-padding" style="width: 250px; height: 250px;">
                                            @if(isset($data->photo))
                                                <img src="{{Config::get('constant.endpoint.url')}}/storage/karyawan/{{$data->photo}}">
                                                @else
                                                <img src="{{asset('assets/img/blankphoto.jpg')}}" alt="...">
                                            @endif;        
                                        
                                        </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail img-circle img-no-padding" style="max-width:250px; max-height: 250px;"></div>
                                        <div>
                                            <br>
                                        </div>
                                    </div>
                                </div><div class="col-lg-9 col-md-9 col-sm-9">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right"><dt>Status:</dt> </div>
                                        <div class="col-sm-8 text-sm-left"><dd class="mb-1">
                                        <span class="label label-primary">
                                        @if($flag>0)  Active @else New  @endif
                                        </span>
                                        </dd></div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right"><dt>Nama Lengkap:</dt> </div>
                                        <div class="col-sm-8 text-sm-left"><dd class="mb-1">
                                        <div class="form-group row has-success"><div class="col-sm-10"><input type="text" value="{{(isset($data->fullname) ? $data->fullname : '')}}" class="form-control" name="nama" style="border-top:none;border-left:none;border-right:none;"></div></div>
                                    </dd> </div>
                                </dl>
                                <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right"><dt>No.KTP:</dt> </div>
                                        <div class="col-sm-8 text-sm-left"><dd class="mb-1">
                                        <div class="form-group row has-success"><div class="col-sm-10"><input type="text" value="{{(isset($data->ktp) ? $data->ktp : '')}}" class="form-control"name="ktp" style="border-top:none;border-left:none;border-right:none;"></div></div>
                                    </dd> </div>
                                </dl>
                                <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right"><dt>Tempat/Tgl Lahir:</dt> </div>
                                        <div class="col-sm-8 text-sm-left"><dd class="mb-1">
                                        <div class="form-group row has-success">
                                            <div class="col-lg-6 col-md-7 col-sm-7"><input type="text" value="{{(isset($data->tempat_lahir) ? $data->tempat_lahir : '')}}" class="form-control" name="tempat_lahir" style="border-top:none;border-left:none;border-right:none;"></div>
                                            <div class="col-lg-4 col-md-3 col-sm-3"><input type="text" value="{{(isset($data->tgl_lahir) ? $data->tgl_lahir : '')}}" class="form-control" name="tgl_lahir" style="border-top:none;border-left:none;border-right:none;"></div>
                                        </div>
                                    </dd> </div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right"><dt>Email:</dt> </div>
                                    <div class="col-sm-8 text-sm-left"> <dd class="mb-1">  
                                        <div class="form-group row has-success"><div class="col-sm-10"><input type="text" value="{{(isset($data->email) ? $data->email : '')}}" class="form-control" name="email" style="border-top:none;border-left:none;border-right:none;"></div></div>
                                    </dd></div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right"><dt>Kontak:</dt> </div>
                                    <div class="col-sm-8 text-sm-left"> <dd class="mb-1">
                                        <div class="form-group row has-success"><div class="col-sm-10"><input type="text" value="{{(isset($data->phone) ? $data->phone : '')}}" class="form-control" name="kontak" style="border-top:none;border-left:none;border-right:none;"></div></div>
                                    </dd></div>
                                </dl>
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right"> <dt>Alamat:</dt></div>
                                    <div class="col-sm-8 text-sm-left"> <dd class="mb-1">
                                            <div class="form-group row has-success"><div class="col-sm-10"><input type="text" value="{{(isset($data->address) ? $data->address : '')}}" class="form-control" name="alamat" style="border-top:none;border-left:none;border-right:none;"></div></div>
                                        </dd></div>
                                    </dl>

                                </div>
                                </form>
                            </div>
                            
                            <div class="row m-t-sm">
                                <div class="col-lg-12">
                                <div class="panel blank-panel">
                                <div class="panel-heading">
                                    <div class="panel-options">
                                        <ul class="nav nav-tabs">
                                            <li><a class="nav-link active show" href="#tab-1" data-toggle="tab">Users messages</a></li>
                                            <li><a class="nav-link" href="#tab-2" data-toggle="tab">Last activity</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body">

                                <div class="tab-content">
                                <div class="tab-pane active show" id="tab-1">
                                    <div class="feed-activity-list">
                                        <div class="feed-element">
                                            
                                            <div class="media-body ">
                                                
                                            </div>
                                        </div>
                                        
                                        
                                    </div>

                                </div>
                                <div class="tab-pane" id="tab-2">

                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Title</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Comments</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                                </div>

                                </div>

                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="wrapper wrapper-content project-manager">
                    <h4>Detail Pencapaian</h4>
                    
                </div>
            </div>
        </div>
@endsection     
@section('css')
<link href="{{asset('assets/css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">   
@stop
@section('js')
<script src="{{asset('assets/js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
<script>
    
$(document).on("click", "#savedata", function (e) { 
	$("#formbiodata").submit();
});	    

/*
$(document).on("submit", "#formbiodata", function (e) { 
	e.preventDefault();
	Hxr(this);
});	
*/

function Hxr(data){
    let formData = new FormData(data);
        // formData.append("flag",privilagepost );
        $.ajaxSetup({
								headers: {
									'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
								}
							})

    $.ajax({
        type: 'POST',
        url:"{{route('Erp Karyawan Add')}}",
        data: formData,
        processData: false,
        contentType: false,	
        success: function(e) {
        //     alert(e.message);
        //    if(e.message=="berhasil"){
        //         // $('#datatable1').DataTable().ajax.reload();
        //         }
        //         // $('#modal-input').modal('hide');
                }
            });		
}

</script>
@stop