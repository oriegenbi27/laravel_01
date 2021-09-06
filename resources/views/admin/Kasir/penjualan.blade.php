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
    <div class="fh-column" style="width:100%;">
        <div class="full-height-scroll">

            <div class="ibox-content">
                <div class="table-responsive">
                    {!! $html->table() !!}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('js')
{!! $html->scripts() !!}
<script type="text/javascript">
$(document).on("dblclick", "#dataTableBuilder>tbody>tr", function (e) {
    let inv=btoa($(this).find('span')[0].innerHTML);
    window.location.href = '{{route('Kasir penjualan detail')}}?code='+inv;
});
</script>
@stop