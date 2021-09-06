@extends('admin.master')
@section('assets')
@endsection
@section('content')
<button id="print"  type="button"  class="btn btn-primary fa fa-print"></button>
{{-- <a href="{{route('send_mail',$purchasing->purchasing->email)}}" id="send"  type="button"  class="btn btn-primary fa fa-envelope"></a> --}}
<div id="isi_sturk">

    <div class="card" >

    <div class="card-body">

        <img style="
        padding: 5px; width: 150px;"  class="card-img-top img-responsive"  src="{{asset('assets/logo/LOGO_BIZPLAN-06.png')}}" alt="Card image cap">
        <span style="color:blue"><p class="card-text">{{$setting->data->prov}} , {{$setting->data->kab}} , {{$setting->data->kec}}, {{$setting->data->kel}} - {{$setting->data->tlp}} / {{$setting->data->hp}}</p></span>



        <table class="table PrintPos">

            <h4 class="card-title text-center">INVOICE PURCHASING ORDER </h4>
            <h2 style=" width: 240px; color: rgb(0, 0, 0); "><strong>[ {{ $purchasing->purchasing->supplier }} ]</strong></h2>

            <h4>Email         :  {{ $purchasing->purchasing->email }}</h4>
            <h4>Nama Supplier : {{ $purchasing->purchasing->alamat }}</h4>
            <h4>Category      : {{ $purchasing->purchasing->category }}</h4>
          <thead style="width: 70%">
            <th>Nama Item</th>
            <th>Harga</th>
            <th>Quantity</th>
            <th>diskon</th>
            <th>unit</th>

          </thead>
          <tbody id="body_struk">
            @foreach($purchasing->purchasing->detailpurchasing as $detail)
                <tr class="records" name="id" id="tr{{$detail->id}}" data-id='{{$detail->id}}'>
                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" type="text" class="form-control" id="nama_item" name="nama_item[]" value='{{$detail->nama}}' readonly/></td>
                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" class="form-control" id="harga" name="harga[]" value='{{$detail->harga}}' readonly /></td>
                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="qty"   data-price=""  data-key=""  value='{{$detail->qty}}'   class="quantityTxt form-control" type="number"  name="qty[]" readonly></td>
                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="diskon"  data-price="" data-key="" value='{{$detail->diskon}}'  min="0" max="9999999999"   class="form-control quantityTxt" type="number" name="diskon[]" readonly></td>
                    <td><input style="background-color: #fff;border-top:none;border-left:none;border-right:none;" id="satuan" value='{{$detail->satuan}}'  class="totalprice form-control" type="text"  name="satuan[]" readonly/></td>

                    </tr>
            @endforeach
          </tbody>
          {{-- <tfoot id="cetak_total">
            <tr>
              <td>Total Belanja :</td>
              <td></td>
              <td id="print_total"></td>
            </tr>
            <tr>
              <td>Bayar :</td>
              <td></td>
              <td id="print_bayar"></td>
            </tr>
            <tr>
              <td>Kembali :</td>
              <td></td>
              <td id="print_kembali"></td>
            </tr>
          </tfoot> --}}
        </table>

    </div>
  </div>
</div>
@endsection
@section('css')
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/dataTables/lib/dataTables/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet"
    href="{{asset('assets/js/plugins/dataTables/lib/datatables.buttons/css/buttons.dataTables.min.css')}}">
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

<!-- Mainly scripts -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.data-karywan').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgtip',
            buttons: [
                {
                    className: 'btn-primary btn-sm ladda-button',
                    titleAttr: 'Add Data',
                    text: '<i class="fa fa-plus" aria-hidden="true"></i>',
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button');
                    },
                    action: function (e, dt, node, config) {
                        window.location = '/add_produk';
                    }
                },
                {
                    extend: 'copy',
                    className: 'btn-primary btn-sm ladda-button',
                    titleAttr: 'Copy Data',
                    text: '<i class="fa fa-clone" aria-hidden="true"></i>',
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button')
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-primary btn-sm ladda-button',
                    titleAttr: 'Save To CSV',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button')
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-primary btn-sm ladda-button',
                    titleAttr: 'Print Data',
                    text: '<i class="fa fa-print" aria-hidden="true"></i>',
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button')
                    }
                },

            ],

        });

    // print struk

    $("#print").click(function (ev) {
                if (ev.type == 'click') {
                    var divName= "isi_sturk";

                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = printContents;

                    window.print();

                    document.body.innerHTML = originalContents;

                }
        });


    });
</script>
@stop
