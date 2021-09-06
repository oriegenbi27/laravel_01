@extends('admin.master')
@section('assets')
@endsection
@section('content')

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox" >
                <form method="POST" id="frmCart">
                    @csrf
                    <div class="ibox-content">
                      <div class="row" style="">
                        @foreach($produk->produk as $row_produk)
                        <div class="col-md-3 text-center"  id="add" onClick="addresult({{$row_produk->id}},'{{$row_produk->nama}}','{{$row_produk->images}}', {{$row_produk->harga}})">
                            <div class="ibox-content border border-primary" style=""  data-id="{{$row_produk->id}}">
                                <div class="body " style="margin-right:80px; margin-bottom:-10px; margin-left:-10px">
                                    @if(isset($row_produk->images))
                                    <img id="img-produk" data-image="{{$row_produk->images}}" class="img-responsive"
                                        height="100px" width="100px"
                                        src="{{Config::get('constant.endpoint.url')}}/storage/produk/{{$row_produk->images}}"
                                        alt="{{$row_produk->nama}}">
                                    @else 
                                    <img data-image="{{$row_produk->images}}" class="img-responsive" height="100px"
                                        width="100px"
                                        src="{{Config::get('constant.endpoint.url')}}/storage/produk/product-default.png"
                                        alt="{{$row_produk->nama}}">
                                    @endif
                                </div>       
                                <input type="hidden" id="harga-produk" name="harga"
                                            value="{{$row_produk->harga}}">
                                        <input type="hidden" id="diskon-produk" name="diskon"
                                            value="{{$row_produk->diskon}}">
                              
                            </div>
                            <div class="col-md-12 text-center bg-primary border border-primary" style="margin-bottom:10px" id="nama-produk" data-nama="{{$row_produk->nama}}">
                                    <h5>{{$row_produk->nama}}</h5>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        @endforeach
                      </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
          $diskon = 0 ;
          $harga  = 0 ;
          $ambil_diskon = 0;
          $harga_diskon = 0;
          $ttl_bayar = 0;
          $jml_item = 0 ;
          $total_item = 0 ;
        ?>
        @foreach($tmp->TmpPos as $count)
        <?php
            $jml_item     = count([$count->id]);
            $qty          = $count->qty;
            $diskon       = $count->join_produk[0]->diskon;
            $harga        = $count->join_produk[0]->harga;
            $ambil_diskon = $harga / $diskon;
            $harga_diskon = $harga - $ambil_diskon;
            $ttl_bayar    += $harga_diskon * $qty ;
            $total_item   += $jml_item * $qty;
          ?>
        @endforeach
        <div class="col-lg-3 animated fadeInRight">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Produk yang di pesan</h5>
                    <div class="ibox-tools">
                        <span id="totalitem" data-total="{{$total_item}}"
                            class="label label-warning-light float-right">{{$total_item}} Item</span>
                    </div>
                </div>
                <div class="ibox-content" >
                    <div>
                        <div class="feed-activity-list"  id="cart">
                            @foreach($tmp->TmpPos as $row_tmp)
                            @if(isset($row_tmp->id))
                            <div class="feed-element lis-cart">
                                <a class="float-left" href="#">
                                    <img alt="image" class="rounded-circle"
                                        src="http://app.bizplan.id/storage/produk/{{$row_tmp->join_produk[0]->images}}">
                                </a>
                                <div class="media-body ">
                                    <a id="removecart" class="float-right text-navy"><i class="fa fa-close"></i></a>
                                    <strong>Nama : <span id="nama">{{$row_tmp->join_produk[0]->nama}}</span></strong>
                                    <br>
                                    <strong id="harga" data-harga="">Harga : Rp.
                                        {{$row_tmp->join_produk[0]->harga}}</strong> <br>
                                    <input id="id_pr" class="id_pr" type="hidden" name="id[]"
                                        value="{{$row_tmp->join_produk[0]->id}}">
                                    <div calss="actions">
                                        <div class="input-group">
                                            <div class="input-group-prepend input-sm">
                                                <small class="input-group-text">QTY</small>
                                            </div>
                                            <input data-qty="{{$row_tmp->join_produk[0]->id}}" class="form-control input-sm qty" id="qty" type="number" min="1"
                                                value="{{$row_tmp->qty}}" name="qty[]" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="feed-element" id="feed-element"></div>
                            @endif
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            <span>Total :</span>Rp <strong onchange="return calcprice(this)"
                                id="total">{{$ttl_bayar}}</strong>
                        </div>
                        <!-- <button id="openmodal" class="btn btn-primary btn-block m-t">Check Out <i
                                class="fa fa-arrow-right"></i>
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- kanan check out -->
        <div class="col-lg-3 animated fadeInRight">
            <div id="isi_sturk">
                <div class="card">

                    <div class="card-body">
                        <img class="card-img-top img-responsive" weight="10px" height="20px"
                            src="{{url('/storage/icon' , $setting->data->images)}}" alt="Card image cap">
                        <h4 class="card-title text-center">Terima Kasih Telah Menggunakan Jasa {{$setting->data->nama}}
                        </h4>
                        <p class="card-text">{{$setting->data->prov}} , {{$setting->data->kab}} ,
                            {{$setting->data->kec}}, {{$setting->data->kel}} - {{$setting->data->tlp}} /
                            {{$setting->data->hp}}</p>
                        <ul class="list-group">
                            <li class="list-group-item">Total Harga<span class="badge text-center"
                                    id="harga_bayar">12</span></li>
                            <li class="list-group-item">Total Bayar <input class="form-control" type="number" min="1"
                                    vallue="1" id="bayar"></li>
                            <!-- <li class="list-group-item">Total Keseluruhan  -->
                              <button id="cetak" class="btn btn-primary"> Check Out <span id="total_bayar">0 </span></button>
                            <!-- </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div style="display:none">
    <div class="feed-element">
        <a class="float-left" href="profile.html">
            <img alt="image" class="rounded-circle" src="img/a4.jpg">
        </a>
        <div class="media-body ">
            <small class="float-right text-navy">5h ago</small>
            <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica
                Smith</strong>. <br>
            <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
            <div class="actions">
                <a href="" class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="posModal" tabindex="-1" role="dialog" aria-labelledby="posModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="posModalLabel">Pilih Jenis Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="cetak" class="btn btn-primary">Cetak struk</button>
            </div>
        </div>
    </div>
</div> -->

<div style="display:none">
    <div id="modal_isi1">
        <div class="form-group row " id="checkout">
            <div class="col-sm-12">
                <label class="col-sm-12 font-weight-bold col-form-label">Jumlah Pembayaran</label>
                <input class="form-control" type="number" id="bayar">
            </div>
            <div class="col-sm-12">
                <label class="col-sm-12 font-weight-bold col-form-label">Jenis Pembayaran</label>
                <select class="form-control m-b" name="jenis_pembayaran" id="jenis_pembayaran">
                    <option value="0">--- Select Pembayaran ---</option>
                    <option value="1">Cash</option>
                    <option value="2">Bank Tranfer</option>
                    <option value="3">Dll</option>
                </select>
            </div>
            <div class="col-sm-12" id="subbank">

            </div>
            <div class="input-group col-sm-12">
                <label class="col-sm-12 font-weight-bold col-form-label">Total Bayar</label>
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" type="number" value="{{$ttl_bayar}}" id="total_bayar" readonly>
            </div>
        </div>
    </div>
    <!-- struk -->
<div id="detail_struk">
   <table>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Diskon</th>
        <th>Harga di Kurang Diskon</th>
      </tr>
    </table>
    <tbody id="isi_detail">
      
    </tbody>
    <tfoot id="isi_hitung">
    
    </tfoot>

</div>

</div>
@endsection
@section('css')
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet"
    href="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/css/buttons.dataTables.min.css')}}">
<!-- Sweet Alert -->
<link href="{{asset('assets/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
@stop
@section('js')
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/tables-datatable.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/dataTables/fnReloadAjax.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/js/buttons.print.min.js')}}"></script>
<!-- Sweet alert -->
<script src="{{asset('assets/js/plugins/sweetalert/sweetalert.min.js')}}"></script>

<!-- Mainly scripts -->
<script type="text/javascript">
    function addresult(id, nama, images, harga) {
        $('#add').ready(function () {
            let jml_item = $('#totalitem').data('total');

            $.ajax({
                "url": '{{route("addToCart")}}',
                'method': 'POST',
                'data-type': 'Json',
                'data': {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "harga": $('#harga-produk').val(),
                    "diskon": $('#diskon-produk').val(),
                },
                'success': function (data, xhr, response) {
                  var arr =[]; 
                   $('.id_pr').each(function(key,val){
                     arr.push(parseInt($(this).val()));
                   });
                   if ($.inArray(id, arr) >  -1){
                      $('.qty').each(function(key,val){
                       if($(this).data('qty') == id){
                         var a = parseInt($(this).val());
                         var b = a + 1;
                         $(this).val(function(index , value){
                          $("#totalitem").text((parseInt(jml_item) + 1) +"Item");
                          $('#totalitem').data('total', parseInt(jml_item)+1).attr('data-total', parseInt(jml_item)+1);
                          console.log(calcprice()); 
                          return value.replace(a,b);
                         })
                       }
                      })
                   }else {
                    var ht = $('.feed-activity-list').append(
                              '<div class="feed-element">' +
                              '<a class="float-left" href="#">' +
                              '<img alt="image" class="rounded-circle" src="http://app.bizplan.id/storage/produk/' +
                              images + '">' +
                              '</a>' +
                              '<div class="media-body ">' +
                              '<a id="removecart" class="float-right text-navy"><i class="fa fa-close"></i></a>' +
                              '<strong>Nama  : ' + nama + '</strong> <br>' +
                              '<strong id="harga" data-harga="' + harga +
                              '">Harga : Rp.' + harga + '</strong> <br>' +
                              '<input id="id_pr" type="hidden" name="id[]" value="' +
                              id + '">' +
                              '<div calss="actions">' +
                              '<div class="input-group">' +
                              '<div class="input-group-prepend input-sm">' +
                              '<small class="input-group-text">QTY</small>' +
                              '</div>' +
                              '<input class="form-control input-sm" id="qty" type="number" min="1" value="1" name="qty[]" />' +
                              '</div>' +
                              '</div>' +
                              '</div>' +
                              '</div>'
                          );
                   }
                },
                'error': function (data, xhr, response) {
                    console.log('error', data, response)
                }
            });
        })
    }
    // jenis pembayarn
    $('#jenis_pembayaran').on('change', function () {
        let jenis = $(this).val();
        if (jenis == 2) {
            $('#subbank').append(
                '<div>' +
                ' <label class="col-sm-12 font-weight-bold col-form-label">Pilih Bank</label>' +
                '<select class="form-control m-b" name="bank" id="bank">' +
                '<option value="0">--- Select bank ---</option>' +
                '<option value="1">BCA</option>' +
                '<option value="2">BRI</option>' +
                '<option value="3">BNI</option>' +
                '</select>' +
                '</div>'
            )
        }
    });


    // isi_struk

    $('#isi_sturk').ready(function () {
        let total = parseInt($('#total').text());
        let modal_total = $('#total_bayar').val(total);
        let bayar = $('#total').text();
        $('#harga_bayar').text('Rp. '+bayar);
        $('#bayar').on('input', function () {
            let bayar = parseInt($(this).val());
            let kurang = '';
            if (bayar <= kurang) {
                kurang = parseInt(modal_total.val() - kurang);
            } else if (bayar >= kurang) {
                let ttk = parseInt(modal_total.val());
                kurang = parseInt(bayar - ttk);
            } else if (!bayar) {
                kurang = total;
            }
            $('#print_bayar').text('Rp ' + bayar);
            $('#print_kembali').text('Rp ' + kurang);
            $('#total_bayar').text('Rp '+ Math.abs(kurang));

        });
    });

    // perhitungan
    function calcprice(e) {
        $.ajax({
            'url': "{{route('getDetailPos')}}",
            'Method': "GET",
            'dataType': "Json",
            "success": function (data, response) {
                // console.log('success' , data , response)
                let diskon = 0;
                let harga = 0;
                let jml_item = 0;
                let ttl_item = 0;
                let ttl_len = 0;
                let ambil_diskon = 0;
                let harga_diskon = 0;
                let ttl_harga = 0;
                let arr = [];
                let qty = 0;
                let len = data.TmpPos.length;

                for (i = 0; i < len; i++) {
                    diskon = parseInt(data.TmpPos[i].join_produk[0].diskon);
                    harga = parseInt(data.TmpPos[i].join_produk[0].harga);
                    qty = parseInt(data.TmpPos[i].qty);
                    ambil_diskon = parseInt(harga / diskon);
                    harga_diskon = parseInt(harga - ambil_diskon);
                    ttl_harga += parseInt(harga_diskon * qty);
                    jml_item += qty;
                    $('#isi_detail').append(
                        '<tr>'+
                          '<td>'+i+'</td>'+
                          '<td>'+data.TmpPos[i].join_produk[0].nama+'</td>'+
                          '<td>'+data.TmpPos[i].join_produk[0].harga+'</td>'+
                          
                        '</tr>'
                )
                };
                $("#totalitem").text(jml_item + " Item");
                $("#total").text("Rp." + ttl_harga);
                $("#total_bayar").val("Rp" + Math.abs(ttl_harga));
                $('#harga_bayar').text('Rp ' + ttl_harga);
                $('#print_total').text('Rp ' + ttl_harga);
                
                
            },
            "error": function (data, response) {
                console.log('error', data, response)
            }
        })
    }

    // proses jika semua sudah selsai
    $('#cetak').on('click', function (event) {
        event.preventDefault();
        $.ajax({
            'url': "{{route('getDetailPos')}}",
            'Method': "GET",
            'dataType': "Json",
            'success': function (data, response) {
                var bayar = $('#bayar').val();
                $.ajax({
                    'url': "{{route('CreateDetail')}}",
                    'Method':"POST",
                    'dataType':"Json",
                    'data':{
                      '_token':"{{ csrf_token() }}",
                      'bayar': bayar,
                    },
                    'success':function(data , response){
                      console.log('success' , data);
                    },
                    'error':function(data , response){
                      console.log('error', data);
                    }
                });

                var len = data.TmpPos.length;
                for (i = 0; i < len; i++) {
                    var harga = parseInt(data.TmpPos[i].join_produk[0].harga);
                    var diskon = parseInt(data.TmpPos[i].join_produk[0].diskon);
                    var hargadiskon = parseInt(harga - (harga / diskon));
                    $('#body_struk').append(
                        '<tr>' +
                        '<td>' + data.TmpPos[i].join_produk[0].nama + '</td>' +
                        '<td>' + parseInt(data.TmpPos[i].join_produk[0].diskon) + '%</td>' +
                        '<td>Rp.' + parseInt(data.TmpPos[i].join_produk[0].harga) + '</td>' +
                        '<td>Rp.' + parseInt(hargadiskon) + '</td>' +
                        '</tr>'
                    );
                };
                var price = calcprice();
            },
            'error': function (data, response) {
                console.log(data, response);

                swal({
                    title: "Terima Kasih",
                    text: "You clicked the button!",
                    type: "error"
                });
            }
        });


        $('.modal-body').html($('#isi_sturk'));
        $('#posModal').modal();
        // $('#cetak').remove();
        // $('.modal-footer').html(
        //     '<button type="button" onClick="printDiv()" class="btn btn-primary">Print</button>'
        // );
    });

    // print struk
    function printDiv() {
        var divName = "detail_struk";

        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

    }
</script>
@stop