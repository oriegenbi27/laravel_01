@extends('admin.kasir')
@section('content')
<div class="fh-breadcrumb">
<div class="full-height">
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
            <div class="ibox-title">
                <h5>Line Chart Example
                    <small>With custom colors.</small>
                </h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="lineChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Master project</td>
                            <td>Patrick Smith</td>
                            <td>$892,074</td>
                            <td>Inceptos Hymenaeos Ltd</td>
                            <td><strong>20%</strong></td>
                            <td>Jul 14, 2015</td>
                            <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Alpha project</td>
                            <td>Alice Jackson</td>
                            <td>$963,486</td>
                            <td>Nec Euismod In Company</td>
                            <td><strong>40%</strong></td>
                            <td>Jul 16, 2015</td>
                            <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                        </tr>
                    </table>
                </div>   
            </div> 
        </div> 
    </div> 
</div> 
</div>
</div>
@php
$datedari='2021-08-01 06:00:00';

    for($i=0;$i<=30;$i++){
        $tanggal[]=[
            strtotime( date ("Y-m-d H:i:s", strtotime("+$i day", strtotime($datedari))) ),
            $i+1
            ];
    }
    $tanggal=json_encode($tanggal);
@endphp
@endsection

@section('css')
@stop
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

    var sparklineCharts = function(){
                $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 52], {
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

                $("#sparkline3").sparkline([34, 22, 24, 41, 10, 18, 16,8], {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#1C84C6',
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
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [

            {
                label: "Data 1",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [28, 48, 40, 19, 86, 27, 90]
            },{
                label: "Data 2",
                backgroundColor: 'rgba(220, 220, 220, 0.5)',
                pointBorderColor: "#fff",
                data: [65, 59, 80, 81, 56, 55, 40]
            }
        ]
    };

    var lineOptions = {
        responsive: true
    };


    var ctx = document.getElementById("lineChart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
            
});
</script>
@stop