@extends('admin.Kasir')
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
<div class="fh-breadcrumb" style="height:86%">
    <div class="fh-column" style="width:70%;">
        <div class="full-height-scroll">
            <div class="row" style="padding: 5px;">
                <div class="col-sm-9">
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
                        <input type="text" class="form-control"></div>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control">
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
                                        <img onclick="calc(this)" alt="{{$row->nama}}" id="img{{$row->id}}" data-img="imgchek{{$row->id}}" data-code="{{$row->code}}" data-title="{{$row->nama}}" data-harga="{{$row->harga}}" data-diskon="{{$row->diskon}}" class="img-fluid" src="{{Config::get('constant.endpoint.live')}}/storage/produk/{{$row->images}}" style="height:100px;width:auto;">
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
                    </tbody>
                </table>
                </div>
                <footer style="
                        position: absolute;
                        bottom: 0px;
                        width: 100%;
                        height: 50px;
                        background-color: #fff;"><button style="width: 100%;" type="button" class="btn btn-w-m btn-primary">
                        <h3 id="allbayar">Bayar Rp 0  <i style="padding-left: 10px;"class="fa fa-chevron-right"></i></h3>
                    </button></footer>
                </div>
            </div> 
    </div>

    {{-- start  next2--}}
    

    {{-- end next2--}}
</div>
@endsection
@section('js')
<script type="text/javascript">
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

                    let hargadiskon=(parseInt(harga*diskon/100)*1) ;
                    let html='<tr id="rowcarting'+code+'">'+
                                '<td><span id="carting" class="carting'+code+' label label-primary" data-qty="1" data-harga="'+harga+'" data-diskon="'+diskon+'">1</span></td>'+
                                '<td class="issue-info"><a href="#">'+title+'</a><small><span class="label float-left label-primary">'+diskon+'%</span></small></td>'+
                                '<td><strong id="harga'+code+'">'+formatRupiah(harga.toString())+'</strong><div class="small m-t-xs"><span id="diskon'+code+'" class="label float-left label-primary">'+formatRupiah(hargadiskon.toString())+'</span></div></td>'+
                                '</tr>';
                    $("#cartrow").append(html);
                    
                    }
    // }

    cartingall();

}

function summerycart(e){
    let flag=false;
    $(".carting"+e).each(function(index,val){
        let qty=parseInt($(val).data("qty")+1);
            $(val).data('qty',qty); 
            $(val).text(qty); 
            let harga= $(val).data('harga');
            let diskon= $(val).data('diskon');
            let hargaall=parseInt(harga*qty);

            let hargadiskon=(parseInt(hargaall*diskon/100));

            $("#diskon"+e).text(formatRupiah(hargadiskon.toString()) );
            $("#harga"+e).text(formatRupiah(hargaall.toString()) );
            $('#rowcarting'+e).css("border-left", "3px solid #f8ac59");
            $('#rowcarting'+e).focus();
            
        flag =true;
    });

    return flag;

}

function cartingall(){
    let harga=0;
    let hargadiskon=0;
    $('span[id="carting"]').each(function(index,val){
        harga   +=parseInt($(val).data("harga")*$(val).data("qty"));
        hargadiskon +=parseInt( harga*$(val).data("diskon")/100 );
    });

    $("#allbayar").html('Bayar '+formatRupiah((harga-hargadiskon).toString())+'<i style="padding-left: 10px;"class="fa fa-chevron-right"></i>');

}
</script>
@stop