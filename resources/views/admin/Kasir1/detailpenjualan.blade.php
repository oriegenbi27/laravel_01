@extends('admin.kasir')
@section('content')
<form id="penjualan-form" method="post" action="">
@csrf
<div class="row">
    <div class="col-lg-6 no-padding">
        <div class="ibox-title bg-primary">
                <h4 id="backpenjualan" style="cursor: pointer;"> <i class="fa fa-chevron-left" style="margin-right:10px"></i> Rincian Pesanan {{$row->data->code}}</h4>
            </div> 
    </div>

    <div class="col-lg-6 no-padding">
        <div class="ibox-title bg-primary">
            <div class="btn-group" style="margin-bottom: -.2rem;">
                <button id="print-data" class="btn btn-info" type="button"><i class="fa fa-print"></i> Print</button>
                <button class="btn btn-success" type="button"><i class="fa fa-send"></i> Email</button>
                <button class="btn btn-info" type="button"><i class="fa fa-exchange"></i> Refaund</button>
            </div>
        </div> 
    </div>
</div>

<div class="fh-column" style="width:70%;">
    <div class="full-height-scroll">
        <div class="ibox-content">
        <div class="table-responsives">
            <table class="table table-hover">
                <thead>
                    <tr colspan="4">
                        <th><input type="checkbox" id="checkAll" name="all"> All Daftar Orderan</th>
                    </tr>
                </thead>
                <tbody id="rincianpesanan">
                @php $item=0;@endphp    
                @foreach($row->data->detailorder as $detail)
                    <tr>
                        <td width="20%">
                         @if($detail->refaund >0)
                            {{$detail->ket}}
                            @else
                         <input type="checkbox" name="cek[]" value="{{$detail->id}}"> 
                         @endif   
                    
                        {{--        
                        <div class="input-group">
                            <span class="btn input-group-addon" data-event="minus" id="{{$detail->id}}" onclick="calc(this)"><i class="fa fa-minus"></i></span>
                            <input type="number" id="text{{$detail->id}}" data-harga="{{$detail->harga}}" data-diskon="{{$detail->diskon}}" class="form-control" value="{{$detail->qty}}" style="width: 0.3rem">
                            <span class="btn input-group-addon" data-event="plus" id="{{$detail->id}}" onclick="calc(this)"><i class="fa fa-plus"></i></span>
                        </div>
                        --}}

                        </td>
                        <td width="10%" class="text-center"><span id="qty{{$detail->id}}">{{$detail->qty}}</span></td>
                        <td width="50%"><span id="nama{{$detail->id}}">{{$detail->nama}}  / Diskon : {{$detail->diskon}}</span></td>
                        <td width="20%"><span id="price{{$detail->id}}">Rp.{{ number_format($detail->total_price,0)}}</span></td>
                    </tr>
                    @php $item +=$detail->qty;@endphp
                @endforeach
                    
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<div class="full-height">
    <div class="full-height-scroll white-bg border-left">
    <div class="table-responsives">
                <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Total Sudah Bayar</th>
                                <th class="text-right">Rp.{{number_format($row->data->grand_total,0)}}</th>
                            </tr>
                            <tr>
                                <th>Total Item</th>
                                <th class="text-right">{{$item}}</th>
                            </tr>
                        </thead>
                </table>

                <table class="table table-hover">
                    <thead>
                        
                        <tr class="text-right"colspan="2">
                            <th>Bayar 1</th>
                        </tr>
                    </thead>
                    <tbody id="bayar">
                        <tr>
                            <td>Kasir</td>
                            <td>xxx</td>
                        </tr>
                        <tr>
                            <td>Cash</td>
                            <td>Rp10.000</td>
                        </tr>
                    </tbody>
                    
                </table>
                <table class="table table-hover">
                    <thead>
                        <tr class="text-right"colspan="2">
                            <th>Bayar 1</th>
                        </tr>
                    </thead>
                    <tbody id="bayar">
                        <tr>
                            <td>Kasir</td>
                            <td>xxx</td>
                        </tr>
                        <tr>
                            <td>Cash</td>
                            <td>Rp10.000</td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
    </div>
</div> 
</div> 

</form>


<div id="modal-print" class="modal fade" style="display: none;width: 180mm" aria-hidden="true">
<div class="modal-dialog" style="padding: 0mm">
    <div class="modal-content">
        <div class="modal-body">
            <table style="width:100%">
                <thead>
                    <tr class="text-center"><th colspan="5">{{strtoupper($row->data->owner->nama)}}</th></tr>
                    <tr class="text-center"><th colspan="5">Tlp:{{$row->data->owner->tlp}} - Email:{{$row->data->owner->email}}</th></tr>
                    <tr>
                        <th colspan="5">Kwitansi : {{$row->data->code}} / {{$row->data->created_at}} /  KasirABC</th>
                    </tr>
                </thead>            
                <tbody style="border-top:dotted;border-bottom:dotted">
                @foreach($row->data->detailorder as $detail)
                    <tr> 
                    <td>{{$detail->nama}} </td> 
                    <td>{{$detail->qty}}</td> 
                    <td>{{number_format($detail->harga,0)}}</td> 
                    <td>{{number_format($detail->total_price,0)}}</td> 
                    </tr>
                @endforeach
                </tbody>
                <tfooter>
                    <tr>
                        <td class="text-right">Total Item</td>
                        <td>:</td>
                        <td class="text-right"colspan="2">{{$item}}</td>
                    </tr>
                    <tr>
                        <td class="text-right">Total</td>
                        <td>Rp.</td>
                        <td class="text-right"colspan="2">{{number_format($row->data->grand_total,0)}}</td>
                    </tr>
                    <tr >
                        <td class="text-right">Bayar</td>
                        <td>Rp.</td>
                        <td class="text-right"colspan="2">{{number_format($row->data->grand_total,0)}}</td>
                    </tr>
                    <tr>
                        <td class="text-right">Kembalian</td>
                        <td>Rp.</td>
                        <td class="text-right"colspan="2">{{number_format($row->data->grand_total,0)}}</td>
                    </tr>
                </tfooter>
            </table>
    </div>
    </div>
</div>
</div>

@endsection
@section('js')
<script type="text/javascript">
    function calc(e){
        let id=e.id;
        let event=$(e).data('event');
        let value=$("#text"+id).val();
        let harga=parseInt($("#text"+id).data('harga'));
        let diskon=parseInt($("#text"+id).data('diskon'));
        let diskonharga=0;
        
        if(event=="minus"){
            value=parseInt(value)-1;
        }else{
            value=parseInt(value)+1;
        }
        
        $("#text"+id).val(value);
        $("#qty"+id).text(value);
        
        if(diskon > 0){
            if(diskon < 100){
                diskonharga=(harga*value)*diskon/100;
            }
        }
        harga=(harga*value);
        $("#price"+id).text(formatRupiah((harga-diskonharga).toString()) );
    }

    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("#sendemail").click(function(){
        $("#penjualan-form").submit();
    });

    $(document).on("click","#backpenjualan",function (e){
        window.location.href ="{{route('Kasir penjualan')}}";	
    });

    

    $(document).on("click","#print-data",function (e){
       // $("#modal-print").modal('show');

       var divName= "modal-print";
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        event.preventDefault();
    });


</script>
@stop