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
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="chart-area pt-4">
                                    <div id="line_chart"></div>
                                </div>
                                <hr>
                                Total File dalam bulan
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="chart-pie pt-4">
                                    <div id="pie_chart"></div>
                                </div>
                                <hr>
                                Total File
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="chart-area pt-4">
                                    <div id="user_chart"></div>
                                </div>
                                <hr>
                                Total User dalam Tahun
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="chart-area pt-4">
                                    <div id="file_chart"></div>
                                </div>
                                <hr>
                                Total File dalam Tahun
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
                <div class="col col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Semua File</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $file }}</div>
                                </div>
                                <div class="col-auto">
                                    <i data-feather="hard-drive"
                                        style="width:48px;height:48px;color:rgba(22, 89, 233, 0.979)"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        File PDF</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pdf }}</div>
                                </div>
                                <div class="col-auto">
                                    <i data-feather="file"
                                        style="width:48px;height:48px;color:rgba(22, 89, 233, 0.979)"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        File Document</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $doc }}</div>
                                </div>
                                <div class="col-auto">
                                    <i data-feather="file-text"
                                        style="width:48px;height:48px;color:rgba(22, 89, 233, 0.979)"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        File Gambar</div>
                                </div>
                                <div class="col-auto">
                                    <i data-feather="image"
                                        style="width:48px;height:48px;color:rgba(22, 89, 233, 0.979)"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                text: 'File by Category'
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
    <script>
        Highcharts.chart('user_chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Users by Years',
            },
            yAxis: {
                title: {
                    text: ''
                },
                labels: {
                    overflow: 'justify'
                },
                gridLineWidth: 0
            },

            xAxis: {
                categories: <?= json_encode($userData['categories']) ?>
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                }
            },

            series: [{
                name: 'User',
                data: <?= json_encode($userData['data']) ?>
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    </script>
    <script>
        Highcharts.chart('file_chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'File by Years',
            },
            yAxis: {
                title: {
                    text: ''
                },
                labels: {
                    overflow: 'justify'
                },
                gridLineWidth: 0
            },

            xAxis: {
                categories: <?= json_encode($fileData['categories']) ?>
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                }
            },

            series: [{
                name: 'File',
                data: <?= json_encode($fileData['data']) ?>
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    </script>
@endsection
