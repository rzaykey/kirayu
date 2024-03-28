@extends('superadmin.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome, {{ auth()->user()->name }}</h1>
        <p class="text-end"> Sangatta,
            <i id="clock"></i>
        </p>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chart</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <div class="row">
                    <div class="col-xl-6 col-lg-5">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="chart-pie pt-4">
                                    <div id="pie_chart"></div>
                                </div>
                                <hr>
                                Total Barang
                            </div>
                        </div>
                    </div>
                    <div class="ccol-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Semua Barang </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $myfile }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i data-feather="hard-drive"
                                            style="width:48px;height:48px;color:rgba(22, 89, 233, 0.979)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-3 g-4">
            </div>
        </div>
    </div>
    <script>
        setInterval(customClock, 500);

        function customClock() {
            var time = new Date();
            var hrs = time.getHours();
            var min = time.getMinutes();
            var sec = time.getSeconds();

            document.getElementById('clock').innerHTML = hrs + ":" + min + ":" + sec;

        }
    </script>
    <script>
        Highcharts.chart('pie_chart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Product by Category'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: <?= json_encode($pie) ?>
            }]
        });
    </script>
@endsection
