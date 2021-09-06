@extends('admin.kasir')
@section('content')
<div class="fh-breadcrumb" style="height:90%;">
    <div class="fh-column" style="width:100%;">
        <div class="full-height-scroll">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="reportrange" class="selectbox pull-right">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                            <input type="hidden" id="rankdate" name="rankdate" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
    <div class="col-sm-4">
        <h1 class="m-b-xs">
            26,900
        </h1>
        <small>
            Penjualan bulan ini
        </small>
        <div id="sparkline1" class="m-b-sm"></div>
        <div class="row">
            <div class="col-4">
                <small class="stats-label">Pages / Visit</small>
                <h4>236 321.80</h4>
            </div>

            <div class="col-4">
                <small class="stats-label">% New Visits</small>
                <h4>46.11%</h4>
            </div>
            <div class="col-4">
                <small class="stats-label">Last week</small>
                <h4>432.021</h4>
            </div>
        </div>

    </div>
    <div class="col-sm-4">
        <h1 class="m-b-xs">
            98,100
        </h1>
        <small>
            Penjualan 24 jam terakhir
        </small>
        <div id="sparkline2" class="m-b-sm"></div>
        <div class="row">
            <div class="col-4">
                <small class="stats-label">Pages / Visit</small>
                <h4>166 781.80</h4>
            </div>

            <div class="col-4">
                <small class="stats-label">% New Visits</small>
                <h4>22.45%</h4>
            </div>
            <div class="col-4">
                <small class="stats-label">Last week</small>
                <h4>862.044</h4>
            </div>
        </div>


    </div>
    <div class="col-sm-4">

        <div class="row m-t-xs">
            <div class="col-6">
                <h5 class="m-b-xs">Penjualan Bulan lalu</h5>
                <h1 class="no-margins">160,000</h1>
                <div class="font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
            </div>
            <div class="col-6">
                <h5 class="m-b-xs">Penjualan tahun ini</h5>
                <h1 class="no-margins">42,120</h1>
                <div class="font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
            </div>
        </div>


        <table class="table small m-t-sm">
            <tbody>
            <tr>
                <td>
                    <strong>142</strong> Projects

                </td>
                <td>
                    <strong>22</strong> Messages
                </td>

            </tr>
            <tr>
                <td>
                    <strong>61</strong> Comments
                </td>
                <td>
                    <strong>54</strong> Articles
                </td>
            </tr>
            <tr>
                <td>
                    <strong>154</strong> Companies
                </td>
                <td>
                    <strong>32</strong> Clients
                </td>
            </tr>
            </tbody>
        </table>



    </div>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
                <div>
                    <canvas id="lineChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-9">
        <div class="ibox ">
        <div class="ibox-title">
            <h5>Rate :: Penjualan Produk </h5>
        </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Code</th>
                            <th>Nama Prodak</th>
                            <th>Total Penjualan</th>
                            <th>Qty</th>
                        </thead>
                        <tbody>
                            @php $no=1 @endphp
                            @if(isset($data->prodak))
                            @foreach($data->prodak as $prodak)
                                <tr>
                                <td>{{$no}}</td>
                                <td>{{$prodak->code}}</td>
                                <td>{{$prodak->nama}}</td>
                                <td>Rp.{{number_format($prodak->amount,0)}}</td>
                                <td>{{$prodak->count}}</td>
                                </tr>
                                @php $no++ @endphp
                            @endforeach
                            @endif
                    </table>
                </div>   
            </div> 
        </div> 
    </div> 
    <div class="col-lg-3">
        <div class="ibox">
        <div class="ibox-title yellow-bg">
            <h5>Rate : Jam Operasional </h5>
        </div>
            <div class="ibox-content yellow-bg no-padding">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            @if(isset($data->time))
                            @foreach($data->time as $time)
                            <tr>
                                <td>Jam : {{$time->jam}}</td>
                                <td>{{$time->count}}</td>
                                <td>Rp.{{number_format($time->amount,0)}}</td>
                            </tr>
                            @endforeach
                            @endif
                    </table>
                </div>   
            </div> 
        </div> 
    </div> 

</div> 
            </div>
        </div>
    </div>
    
</div>

@endsection
@section('js')
<script src="{{asset('assets/js/plugins/chartJs/Chart.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
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

          window.location.href ="{{route('Kasir laporan')}}"+"?s="+btoa(starrank) ;	
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

    var sparklineCharts = function(){
                $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 52,61,67,71,80,91,100,102,105,109,115,120,130,200,201,205,215,220,221,231,240,251,261,271], {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#1ab394',
                    fillColor: "transparent"
                });

                $("#sparkline2").sparkline([32, 11, 25, 37, 41, 32, 34, 42], {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#1ab394',
                    fillColor: "transparent"
                });

            };

            var sparkResize;

            $(window).resize(function(e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineCharts, 500);
            });

            sparklineCharts();


            var lineData = {
                        labels: {!! json_encode(isset($data->harian)?$data->harian->day:[]) !!},
                        datasets: [

                            {
                                label: "Total Penjualan",
                                backgroundColor: 'rgba(26,179,148,0.5)',
                                borderColor: "rgba(26,179,148,0.7)",
                                pointBackgroundColor: "rgba(26,179,148,1)",
                                pointBorderColor: "#fff",
                                data:  {{ json_encode( isset($data->harian)?$data->harian->amount:[] ) }}
                            }
                        ]
                };

    var lineOptions = {
        responsive: true,
        legend:{display: false},
        tooltips: {
                callbacks: {
                    title: function(tooltipItem, data) {
                    return data['labels'][tooltipItem[0]['index']];
                    },
                    label: function(tooltipItem, data) {
                    return formatRupiah( data['datasets'][0]['data'][tooltipItem['index']].toString());
                    },
                },
                backgroundColor: '#faed7d',
                titleFontSize: 16,
                titleFontColor: '#0066ff',
                bodyFontColor: '#000',
                bodyFontSize: 14,
                displayColors: false
                }
    };


    var ctx = document.getElementById("lineChart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
            
});
</script>
@stop