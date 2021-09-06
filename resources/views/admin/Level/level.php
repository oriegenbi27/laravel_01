@extends('admin.master')
@section('assets')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Jenis Barang Add</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('Setting Jabatan')}}">Jabatan</a>
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
        <div class="col-lg-12">
            <div class="ibox border">
                <div class="ibox-title">
                    <h5>Satuan <small></small></h5>
                    <div class="ibox-tools">
                        <a class="btn " href="{{route('Setting Jabatan')}}" title="back">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content border ">
                    <table class="table table-striped  data-karywan" style="width:100%">
                        <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>View</th>
                                    <th>Add</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $view = [] ;$no = 0 ; ?>
                                @csrf
                                @foreach($menu->data as $row)
                                  @if(empty($level->data))
                                  <tr>
                                    <td>{{$row->title}}</td>
                                    <td class="text-center">
                                        <input type="hidden" name="id[]" value="<?php echo $row->id ?>"  value="off">
                                        <input type="checkbox" name="akses_view[<?php echo $row->id ?>]" />
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="id[]" value="<?php echo $row->id ?>"  value="off">
                                        <input type="checkbox" name="akses_insert[<?php echo $row->id ?>]" />
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="id[]" value="<?php echo $row->id ?>"  value="off">
                                        <input type="checkbox" name="akses_edit[<?php echo $row->id ?>]" />
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="id[]" value="<?php echo $row->id ?>"  value="off">
                                        <input type="checkbox" name="akses_delete[<?php echo $row->id ?>]"/>
                                        <input type="hidden" name="jabatan_id[]" value="{{$jabatan_id}}">
                                    </td>
                                  </tr>
                                  @elseif(isset($level))
                                  <?php
                                  // dd($detail);
                                  $list = $detail->data->level;
                                  $count = count($list);
                                  foreach($list as $chk){
                                    // dd($chk->jabatan_id);
                                    if(isset($chk->id)){
                                      $view[$chk->jabatan_id][$chk->menu_id]['akses_view'] ="checked";
                                      $view[$chk->jabatan_id][$chk->menu_id]['akses_insert'] ="checked";
                                      $view[$chk->jabatan_id][$chk->menu_id]['akses_delete'] ="checked";
                                      $view[$chk->jabatan_id][$chk->menu_id]['akses_edit'] ="checked";
                                    }else{
                                      $view[$chk->jabatan_id][$chk->menu_id]['akses_view'] ="";
                                      $view[$chk->jabatan_id][$chk->menu_id]['akses_insert'] ="";
                                      $view[$chk->jabatan_id][$chk->menu_id]['akses_delete'] ="";
                                      $view[$chk->jabatan_id][$chk->menu_id]['akses_edit'] ="";
                                    }
                                  }
                                ?>
                                  <tr>
                                    <td>{{$row->title}}</td>
                                    <td class="text-center">
                                        <input type="hidden" name="id[]" value="<?= $row->id ?>"  value="off">
                                        <input type="checkbox" name="akses_view[<?= $row->id ?>]" <?= $view[$jabatan_id][$row->id]['akses_view'] == TRUE ? 'checked' : "" ?>/>
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="id[]" value="<?= $row->id ?>"  value="off">
                                        <input type="checkbox" name="akses_insert[<?= $row->id ?>]" <?= $view[$jabatan_id][$row->id]['akses_insert'] == TRUE ? 'checked' : "" ?>/>
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="id[]" value="<?= $row->id ?>"  value="off">
                                        <input type="checkbox" name="akses_edit[<?= $row->id ?>]" <?= $view[$jabatan_id][$row->id]['akses_edit'] == TRUE ? 'checked' : "" ?>/>
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="id[]" value="<?= $row->id ?>"  value="off">
                                        <input type="checkbox" name="akses_delete[<?= $row->id ?>]" <?= $view[$jabatan_id][$row->id]['akses_delete'] == TRUE ? 'checked' : "" ?>/>
                                        <input type="hidden" name="jabatan_id[]" value="{{$jabatan_id}}">
                                    </td>
                                </tr>		
                                  @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>
                                        <button id="save" class="btn btn-danger btn-lg" type="reset">Cancel</button>
                                        <button class="btn btn-primary btn-lg" type="submit">Save </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
