@extends('admin.kasir')
@section('content')
<style>
    label:before {
  content:"";// url("https://cdn1.iconfinder.com/data/icons/windows8_icons_iconpharm/26/unchecked_checkbox.png");
  position: absolute;
  z-index: 100;
}
:checked+label:before {
 /* content: url("https://cdn1.iconfinder.com/data/icons/windows8_icons_iconpharm/26/checked_checkbox.png"); */
  content:var(-imgchek);
  margin:5px;
  right: 0;
}
input[type=checkbox] {
  display: none;
}
/*pure cosmetics:*/
/* img {
  width: 150px;
  height: 150px;
} */

label {
    margin: 0 !important;
}

tr:focus-within {
  background:yellow;
}

.product-price {
    font-size: 14px;
    font-weight: 600;
    color: #ffffff;
    background-color: #51b9f7;
    padding: 3px 3px !important;
    position: absolute;
    top: -30px !important;
    right: 0;
}


    
    </style>
<div id="next1" class="fh-breadcrumb" style="height:86%;">
    <div class="fh-column" style="width:70%;">
        <div class="full-height-scroll">
            <div class="row" style="padding: 5px;">
                <div class="col-sm-4">
                    <div class="btn-group">
                        <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                        <button class="btn btn-white">1</button>
                        <button class="btn btn-white  active">2</button>
                        <button class="btn btn-white">3</button>
                        <button class="btn btn-white">4</button>
                        <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="input-group m-b">
                        <div class="input-group-prepend">
                            <button tabindex="-1" class="btn btn-white" type="button">Action</button>
                            <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button" aria-expanded="false"></button>
                            <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 35px; left: 63px; will-change: top, left;">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                 <input type="text" class="form-control" id="serchcode">
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                 @foreach($data->produk as $row)
                    <div class="col-md-2" style="padding:2px">
                            <div class="ibox" style="margin-bottom:2px">
                                <div class="ibox-content product-box">
                                    <div class="product-imitation no-padding">
                                        <input type="checkbox" id="imgchek{{$row->id}}" />
                                        <label class="imgchek{{$row->id}}" for="imgchek{{$row->id}}">
                                                <img onclick="calc(this)" alt="{{$row->nama}}" id="img{{$row->code}}" data-img="imgchek{{$row->id}}" data-code="{{$row->code}}" data-title="{{$row->nama}}" data-harga="{{$row->harga}}" data-diskon="{{$row->diskon}}" class="img-fluid" src="{{Config::get('constant.endpoint.live')}}/storage/produk/{{$row->images}}" style="height:100px;width:auto;cursor: pointer;">
                                            </label>
                                    </div>
                                    <div class="product-desc" style="padding:10px">
                                        <span class="product-price">Rp {{number_format($row->harga,0)}}</span>
                                        <a href="#" class="product-name" style="font-size:12px"> {{$row->nama}}</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                @endforeach   
                </div>
            </div>
        </div>
    </div>
    <div class="full-height">
        <div class="full-height-scroll white-bg border-left">
            <div class="table-responsives">
                <table class="table table-hover issue-tracker">
                    <tbody id="cartrow">
                        @php $totalbayar=0 @endphp
                        @if(isset($cart->detailorder))
                        @foreach($cart->detailorder as $carting)
                        <tr id="rowcarting{{$carting->code}}">
                            <td><span id="carting" class="carting{{$carting->code}} label label-primary" data-code="{{$carting->code}}" data-qty="{{$carting->qty}}" data-title="{{$carting->nama}}" data-harga="{{$carting->harga}}" data-diskon="{{$carting->diskon}}">{{$carting->qty}}</span></td>
                            <td class="issue-info"><a href="#">{{$carting->nama}}</a><small><span class="label float-left label-primary">{{$carting->diskon}}%</span></small></td>
                            <td><strong id="harga{{$carting->code}}">{{number_format($carting->total_price,0)}}</strong><div class="small m-t-xs"><span id="diskon{{$carting->code}}" class="label float-left label-primary">{{number_format( ($carting->harga*$carting->qty)-($carting->total_price) ,0)}}</span></div></td>

                            @php
                            $totalbayar +=$carting->total_price
                            @endphp
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
                <footer style="
                        position: absolute;
                        bottom: 0px;
                        width: 100%;
                        height: 50px;
                        background-color: #fff;">
                        <button id="allbayar" style="width: 100%;display:{{isset($cart->code)?'block':'none'}}" type="button" class="btn btn-w-m btn-primary">
                        <h3 class="allbayar">Bayar Rp {{number_format($totalbayar,0)}}  <i style="padding-left: 10px;"class="fa fa-chevron-right"></i></h3>
                        </button>
                </footer>
        </div>
    </div> 
</div>

<div id="next2" class="row white-bg" style="height:90%;display:none;">
    <div class="col-sm-5 no-padding">  
        <div class="ibox-title bg-primary">
            <h4 id="backcarting" style="cursor: pointer;"> <i class="fa fa-chevron-left" style="margin-right:10px"></i> Rincian Pesanan</h4>
        </div>  
        <div class="table-responsives">
            <table class="table table-hover">
                <tbody id="rincianpesanan">
                    <tr><td><span class="badge badge-primary">16</span></td><td>How all this mistaken</td><td>Rp10.000</td></tr>
                    <tr><td><span class="badge badge-primary">16</span></td><td>How all this mistaken</td><td>Rp10.000</td></tr>
                    <tr><td><span class="badge badge-primary">16</span></td><td>How all this mistaken</td><td>Rp10.000</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-7 no-padding">
    <div class="ibox-title bg-primary">
            <h4> Pembayaran</h4>
        </div>  
    <div class="row">    
    <div class="col-sm-7">    
        <div class="table-responsives">
            <table class="table table-striped" style="font-size: 24px;font-weight: bold;color: #192a8b;">
                <tbody>
                    <tr><td>Total Bayar</td><td class="text-right"><strong id="tagihan-text">Rp10.000</strong><input type="hidden" id="tagihan" value="10000"></td></tr>
                    <tr><td>Pembayaran</td><td class="text-right"><strong id="pembayaran"></strong></td></tr>
                    <tr><td>Kupon</td><td class="text-right">0</td></tr>
                    <tr><td>Point</td><td class="text-right">0</td></tr>
                    <tr><td>Sisa</td><td class="text-right"><strong id="sisa">0<strong></td></tr>
                    <tr><td>Kembali</td><td class="text-right"><strong id="kembali">0<strong></td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-5 no-padding">    
        <h4>Pembayaran Tunai</h4>
        <button type="button" class="btn btn-outline btn-primary" id="tunai-k1" data-pay="pass" onclick="paycalc(this)">Uang Pass</button>
        <button type="button" class="btn btn-outline btn-primary" id="tunai-k1" data-pay="10000" onclick="paycalc(this)">10K</button>
        <button type="button" class="btn btn-outline btn-primary" id="tunai-k2" data-pay="50000" onclick="paycalc(this)">50K</button>
        <button type="button" class="btn btn-outline btn-primary" id="tunai-k4" data-pay="100000" onclick="paycalc(this)">100K</button>
        <button type="button" class="btn btn-outline btn-primary" id="tunai-k5">Lainnya</button>
        <h4>Pembayaran Lainnya</h4>
        <button type="button" class="btn btn-outline btn-primary">EDC</button>
        <button type="button" class="btn btn-outline btn-primary">Transfer</button>
        <button id="pay_wallet" type="button" class="btn btn-outline btn-primary">Wallet</button>
        <button type="button" class="btn btn-outline btn-primary">Voucher</button>
        <button type="button" class="btn btn-outline btn-primary">Deposit</button>
        <h4>Promo</h4>
        <button type="button" class="btn btn-outline btn-primary">Diskon</button>
        <button type="button" class="btn btn-outline btn-primary">Kupon</button>
        <button type="button" class="btn btn-outline btn-primary">Point</button>
        <button type="button" class="btn btn-outline btn-primary">Compliment</button>
        <p>
        <div class="hr-line-dashed"></div>
        <button type="button" class="btn btn-block btn-outline btn-primary">Save Bayar</button>
        </p>
    </div>
</div>    
   
    <footer style="position:absolute;bottom:60px;width:100%;height: 70px;background-color: #fff;padding: 5px;">
        <div class="row" style="height:100%">
            <div class="col-sm-5"> 
                <h4 id="footer-totalbayar">Total Bayar Rp.1000.00</h4>   
            </div>
            <div class="col-sm-7">
                <div class="row" style="height:100%">    
                    <div class="col-sm-7">   
                        <!-- <button type="button" class="btn btn-primary btn-lg" style="height:100%">Large button</button>   
                        <button type="button" class="btn btn-primary btn-lg" style="height:100%">Large button</button>   -->
                    </div>   
                    <div class="col-sm-5">   
                        <!-- <button type="button" class="btn btn-primary btn-lg" style="height:100%;width:100%">Bayar</button>    -->
                    </div>  
                </div>        
            </div>
        </div>
    </footer>
</div>
<form id="payment-form" method="post" action="">
<input type="hidden" id="valdata" name="valdata" value="20001"/>  
<input type="hidden" name="result_type" id="result-type" value="">
<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>
@endsection
@section('js')
<script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="SB-Mid-client-y8k0Wzg5f85XDkbO"></script>

<script type="text/javascript">
var invoicecode="{{isset($cart->code)?$cart->code:null}}";

function calc(e){
    let id=e.id;
    let img=$("#"+id).data('img');
    let code=$("#"+id).data('code');
    let harga=$("#"+id).data('harga');
    let title=$("#"+id).data('title');
    let diskon=$("#"+id).data('diskon');

    // if($('#'+img).is(':checked') ){
    //     alert("Apakah anda yakin hapus daftar belanja");
    //     $("#rowcarting"+code).remove();
    // }else{

            if(!summerycart(code)){
                let arry=[];
                    let hargadiskon=(parseInt(harga*diskon/100)*1) ;
                    let html='<tr id="rowcarting'+code+'">'+
                                '<td><span id="carting" class="carting'+code+' label label-primary" data-qty="1" data-code="'+code+'" data-title="'+title+'" data-harga="'+harga+'" data-diskon="'+diskon+'">1</span></td>'+
                                '<td class="issue-info"><a href="#">'+title+'</a><small><span class="label float-left label-primary">'+diskon+'%</span></small></td>'+
                                '<td><strong id="harga'+code+'">'+formatRupiah(harga.toString())+'</strong><div class="small m-t-xs"><span id="diskon'+code+'" class="label float-left label-primary">'+formatRupiah(hargadiskon.toString())+'</span></div></td>'+
                                '</tr>';
                    $("#cartrow").append(html);

                    $("#allbayar").css('display','block');
                    cartsave(arry=[code,1,hargadiskon]);
                    
                    }
    // }

    cartingall();

}



function summerycart(e){
    let flag=false;
    let allbayar=0;
    $(".carting"+e).each(function(index,val){
        let qty=parseInt($(val).data("qty")+1);
            $(val).data('qty',qty); 
            $(val).text(qty); 
            let harga= $(val).data('harga');
            let diskon= $(val).data('diskon');
            let hargaall=parseInt(harga*qty);

            let hargadiskon=(parseInt(hargaall*diskon/100));


            allbayar    +=hargaall-hargadiskon;

            $("#diskon"+e).text(formatRupiah(hargadiskon.toString()) );
            $("#harga"+e).text(formatRupiah(hargaall.toString()) );
            $('#rowcarting'+e).css("border-left", "3px solid #f8ac59");
            $('#rowcarting'+e).focus();

            cartsave(arry=[e,qty,allbayar]);
            
        flag =true;
    });

    return flag;

}

function cartsave(data){
    $.ajax({
                "url": '{{route('Kasir carting')}}',
                'method': 'POST',
                'data-type': 'Json',
                'data': {
                    "_token": "{{ csrf_token() }}",
                    "data": data,
                    "inv": invoicecode
                },
                'success': function (data, xhr, response){
                    invoicecode=data['inv'];
                },
                'error': function (data, xhr, response) {
                    console.log('error', data, response);
                }
            });
}
var cartingar=[];
function cartingall(){
    let allbayar=0;
    
    $('span[id="carting"]').each(function(index,val){
        let harga=0;
        let hargadiskon=0;
        // let cart=[];
        let code=$(val).data("code");
        let qty=$(val).data("qty");

        harga       =parseInt($(val).data("harga")*qty);
        hargadiskon =parseInt( harga*$(val).data("diskon")/100 );
        allbayar    +=harga-hargadiskon;
        

    });

    $(".allbayar").html('Bayar '+formatRupiah((allbayar).toString())+'<i style="padding-left: 10px;"class="fa fa-chevron-right"></i>');

}

function paycalc(e){
    let tagihan=$("#tagihan").val();
    let bayar=$(e).data('pay');
    if(bayar=="pass"){
        bayar=tagihan;
    }

    $("#pembayaran").text(formatRupiah(bayar.toString()) );
    $("#kembali").text(formatRupiah( (parseInt(bayar-tagihan)).toString() ));
    $("#sisa").text(formatRupiah( (parseInt(tagihan-bayar)).toString() ));
}


$(document).on("click","#backcarting",function (e){
    $("#next1").css('display','block');
    $("#next2").css('display','none');
});
$(document).on("click","#allbayar",function (e){
    $("#rincianpesanan").html("");
    let tagihan=0;

    $('span[id="carting"]').each(function(index,val){
        let html="";
        let qty=$(val).data("qty");
        let code=$(val).data("code");
        let hargaori=$(val).data("harga");
        let title=$(val).data("title");
        let harga=0;
        let hargadiskon=0;
        let fixharga=0;
        let hargasatuandiskon=0;
        let cart=[];

        harga   =parseInt(hargaori*qty);
        hargadiskon =parseInt( harga*$(val).data("diskon")/100 );
        hargasatuandiskon =parseInt(hargaori) - parseInt( hargaori*$(val).data("diskon")/100 );
        fixharga =harga-hargadiskon;
        tagihan +=fixharga;
        html =' <tr><td><span class="badge badge-primary">'+qty+'</span></td><td>'+$(val).data("title")+'</td><td>'+formatRupiah((fixharga).toString())+'</td></tr>';
        $("#rincianpesanan").append(html);

        cart=[code,title,hargasatuandiskon,qty];
        cartingar.push(cart);
    });

    if(cartingar.length > 0){
        $("#tagihan-text").text(formatRupiah(tagihan.toString()) );
        $("#tagihan").val(tagihan);
        $("#footer-totalbayar").text('Total Bayar '+formatRupiah(tagihan.toString()) );

        $("#next1").css('display','none');
        $("#next2").css('display','flex');
    }else{
        alert('sory kerangjang belanja anda masih kosong');
    }
});



$(document).on("keyup","#serchcode",function (e){
    $("#img"+this.value).trigger("click");
    $(this).val("");
});


$('#pay_wallet').click(function (event) {
      event.preventDefault();
    //   $(this).attr("disabled", "disabled");
    $.ajax({
      type:'GET',  
      url:'{{route('kasir payment')}}',
      data: {
                "_token": "{{ csrf_token() }}",
                "data": cartingar,
                "inv": invoicecode
                },
        // data:{'data':$("#valdata").val()},
      cache: false,
      success: function(data) {
        
        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type,data){
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
        }

        snap.pay(data, {
          
          onSuccess: function(result){
            changeResult('success', result);
            console.log(result.status_message);
            //$("#payment-form").submit();
            alert(result.status_message);
            location.reload();
          },
          onPending: function(result){
            changeResult('pending', result);
            console.log(result.status_message);
            // $("#payment-form").submit();
            alert(result.status_message);
            location.reload();
          },
          onError: function(result){
            changeResult('error', result);
            console.log(result.status_message);
            console.log("errro",result);
            alert(result.status_message);
            //$("#payment-form").submit();
          }
        });
      }
    });
  });

</script>
@stop