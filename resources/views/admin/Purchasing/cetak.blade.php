<!DOCTYPE html>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4">
        <h2>Invoice</h2>
    </div>

    <div class="col-lg-8">
        <div class="title-action">
            <form action="{{route('Edit tglkirim' , $purchasing->data->id)}}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <a class="btn btn-white">Pilih tanggal kirim barang </a>
                <input type="date" value="{{ $purchasing->data->tgl_kirim }}" name="tgl_kirim"
                    class="form-default">
                <button id="save" class="btn btn-white" type="submit"><i class="fa fa-check "></i> Save </button>
                <button id="print" class="btn btn-primary" type="button"><i class="fa fa-print"></i> Print Invoice
                </button>
            </form>
            {{-- href="{{route('Edit Purchasing',$purchasing->purchasing->id)}}" --}}
        </div>
    </div>
</div>
<html>
<div id="white-bg">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Bizplan.id | Invoice Print</title>

        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

        <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

    </head>

    <body class="white-bg">
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>From:</h5>
                        <address>
                            <strong>{{$purchasing->data->owner->nama}}.</strong><br>
                            {{$purchasing->data->owner->addr}}<br>
                            {{$purchasing->data->owner->kab}} , {{$purchasing->data->owner->kec}},
                            {{$purchasing->data->owner->kel}}, {{$purchasing->data->owner->kode_pos}}<br>
                            <abbr title="Phone">P: {{$purchasing->data->owner->hp}}</abbr> /
                            {{$purchasing->data->owner->tlp}}
                        </address>
                    </div>

                    <div class="col-sm-6 text-right">
                        <h4>Invoice No.</h4>
                        <h4 class="text-navy">{{ $purchasing->data->code }}</h4>
                        <span>To:</span>
                        <address>
                            <strong>{{ $purchasing->data->supplier }}</strong><br>
                            {{ $purchasing->data->alamat }}<br>

                            <abbr title="Email">Email:</abbr> {{ $purchasing->data->email }}
                        </address>
                        <p>
                            <span><strong>Invoice Date:</strong> {{ $purchasing->data->created_at }}</span><br />


                            <span><strong>Due Date:
                                    @php $dudate=Date('Y:m:d H:i:s', strtotime($purchasing->data->created_at.'+3
                                    days')); @endphp
                                    {{$dudate}}

                                </strong> </span>
                        </p>
                    </div>
                </div>

                <div class="table-responsive m-t">
                    <table>
                        <thead>
                            <tr>
                                <th width="15%">Jenis Barang</th>
                                <th width="20%">Nama Barang</th>
                                <th width="15%">Harga</th>
                                <th width="10%">Quantity</th>
                                <th width="10%">Diskon</th>
                                <th width="10%">Unit</th>
                                <th width="20%">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody class="invoice-table">
                            @foreach($purchasing->data->detailpurchasing as $detail)
                            <tr class="records" name="id" id="tr{{$detail->id}}" data-id='{{$detail->id}}'>
                                <td width="15%"><input
                                    style="background-color: #fff;border-top:none;border-left:none;border-right:none;"
                                    type="text" class="form-control" id="nama_item" name="nama_item[]"
                                    value='{{$detail->jenis_barang}}' readonly /></td>
                                <td width="20%"><input
                                        style="background-color: #fff;border-top:none;border-left:none;border-right:none;"
                                        type="text" class="form-control" id="nama_item" name="nama_item[]"
                                        value='{{$detail->nama}}' readonly /></td>
                                <td width="15%"><input
                                        style="background-color: #fff;border-top:none;border-left:none;border-right:none;"
                                        class="form-control" id="harga" name="harga[]" value='{{$detail->harga}}'
                                        readonly /></td>
                                <td width="10%"><input
                                        style="background-color: #fff;border-top:none;border-left:none;border-right:none;"
                                        id="qty" data-price="" data-key="" value='{{$detail->qty}}'
                                        class="quantityTxt form-control" type="number" name="qty[]" readonly></td>
                                <td width="10%"><input
                                        style="background-color: #fff;border-top:none;border-left:none;border-right:none;"
                                        id="diskon" data-price="" data-key="" value='{{$detail->diskon}}' min="0"
                                        max="9999999999" class="form-control quantityTxt" type="number" name="diskon[]"
                                        readonly></td>
                                <td width="10%"><input
                                        style="background-color: #fff;border-top:none;border-left:none;border-right:none;"
                                        id="satuan" value='{{$detail->satuan}}' class="totalprice form-control"
                                        type="text" name="satuan[]" readonly /></td>
                                <td width="20%"><input
                                            style="background-color: #fff;border-top:none;border-left:none;border-right:none;"
                                            id="satuan" value='{{$detail->total_harga}}' class="totalprice form-control"
                                            type="text" name="satuan[]" readonly /></td>
                                         
                            </tr>
                            @endforeach
                           
                           
                        </tbody>
                        
                        <thead>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        <thead>
                        <tbody>
                        <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Grand Total</strong></td>
                        <td><input
                            style="background-color: #fff;border-top:none;border-left:none;border-right:none;"
                            id="satuan" value='{{ $purchasing->data->grand_total }}' class="totalprice form-control"
                            type="text" name="satuan[]" readonly /></td>
                        </tr>
                    </tbody>
                    </table>
                </div><!-- /table-responsive -->
                <br>
                {{-- <table class="table invoice-total">
                                <tbody>
                                <tr>
                                    <td><strong>Sub Total :</strong></td>
                                    <td>$1026.00</td>
                                </tr>
                                <tr>
                                    <td><strong>TAX :</strong></td>
                                    <td>$235.98</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td>$1261.98</td>
                                </tr>
                                </tbody>
                            </table> --}}
                {{-- <div class="well m-t"><strong>Comments</strong>
                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                            </div> --}}
            </div>

        </div>


</div>
</body>

</html>
<!-- Mainly scripts -->


<script src="{{asset('assets/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
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

<!-- Custom and plugin javascript -->


<script type="text/javascript">
    // $('#save').click(function(){
    //     event.preventDefault();
    //     console.log("berhasil");
    // });

    $('#print').click(function () {
        var divName = "white-bg";

        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
        // event.preventDefault();
    });
</script>
