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
<div class="row">
    <div class="col-lg-6 no-padding">
        <div class="ibox-title bg-default">
            <h4 id="backcarting" style="cursor: pointer;"> <i class="fa fa-chevron-left" style="margin-right:10px"></i> Rincian Pesanan</h4>
        </div>  
    </div>

    <div class="col-lg-6 no-padding">
    <div class="ibox-title  text-right bg-default">
        <button type="button" class="btn btn-outline btn-primary">Email</button>    
        <button type="button" class="btn btn-outline btn-success">Refaund</button>    
        <button type="button" class="btn btn-outline btn-info">Cetak</button>    
    </div>
    </div>
</div>

<div class="fh-column" style="width:40%;">
    <div class="full-height-scroll">
        <div class="ibox-content no-padding">
        <div class="table-responsives">
            <table class="table table-hover">
                <thead>
                    <tr colspan="2">
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
                    <tr colspan="2">
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

<div class="full-height">
    <div class="full-height-scroll white-bg border-left">
    <div class="table-responsives">
            <table class="table table-hover">
                <thead>
                    <tr colspan="4">
                        <th><input type="checkbox">Daftar Orderan</th>
                    </tr>
                </thead>
                <tbody id="rincianpesanan">
                    <tr>
                        <td>
                        <div class="input-group">
                            <span class="btn input-group-addon"><i class="fa fa-minus"></i></span>
                            <input type="text" class="form-control" value="10" style="width: 0.3rem">
                            <span class="btn input-group-addon"><i class="fa fa-plus"></i></span>
                        </div>
                        </td>
                        <td>2</td>
                        <td>How all this mistaken</td>
                        <td>Rp10.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> 

@endsection
@section('js')
@stop