@extends('admin.master')
@section('assets')
@endsection
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Setting Hak Akses</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('Setting Jabatan')}}">Hak Akses</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Setting Hak Akses</strong>
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
                    <h5>Hak Akses <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{route('Setting Jabatan')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                  <div class="row">
                    <div class="col-md-12 text-center"><h2><b>ROLE PRIVILAGE USER</b></h2></div>
                  </div>
                  <form action="#" method="POST" enctype="multipart/form-data">
                          @csrf
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <th>Menu</th>
                            <th>Privilage</th>
                          </thead>
                          <tbody>
                            @foreach($menu as $row)
                            <?php
                             foreach($row->menu as $menu){
                               dd($menu->title);
                             }
                            ?>
                            <tr>
                              <td>Home</td>
                              <td>
                                <ul class="list-group">
                                  <li class="list-group-item">
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="home">
                                    <label class="form-check-label" for="viewHome">View Home</label>
                                  </div>
                                  </li>
                                </ul>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

<scrIpt>
$(function () {
    $('select').selectpicker();
});
</scrIpt>
@stop