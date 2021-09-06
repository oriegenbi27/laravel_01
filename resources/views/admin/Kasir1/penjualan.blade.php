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
            <div class="col-md-12">
            <div id="reportrange" class="selectbox pull-left">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
                <input type="hidden" id="rankdate" name="rankdate" value="">
            </div>
            </div>
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
$(function () {
  var filter=0;
  var da=atob('{{request()->has('s') ? request()->get('s') : '' }}');
  let dm=da.split(":");
  if(da !=""){
    var start =moment(dm[0],"YYYY-MM-DD");
    var end =moment(dm[1],"YYYY-MM-DD");
  }else{
    var start =moment().subtract(30, 'days');
    var end =moment(); 
  }
    function cb(start, end) {
        $('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
        filter +=1;
        if(filter>1){
          let starrank=start.format('YYYY-MM-DD') + ':' + end.format('YYYY-MM-DD');

          $("#rankdate").val(btoa(starrank));

          window.location.href ="{{route('Kasir penjualan')}}"+"?s="+btoa(starrank) ;	
        }
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    },cb);
    cb(start, end);
});

$(document).on("dblclick", "#dataTableBuilder>tbody>tr", function (e) {
    let inv=btoa($(this).find('span')[0].innerHTML);
    window.location.href = '{{route('Kasir penjualan detail')}}?code='+inv;
});
</script>
@stop