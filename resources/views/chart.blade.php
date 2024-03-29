<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin 2 - Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" style="margin-left:30px;margin-top:30px">

                    <!-- Page Heading -->
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div> -->

                    <!-- Content Row -->
                    <h2>Active Date Range: 23 December 2023 - 21 January 2024</h2></br>
                    <h5>Date range and Grouping</h5>
                    <div class="row">
                        <form action="{{ route('formResult') }}" id="myForm" method = "get" class="form-control">
                            @csrf
                            <div class="row">
                                <div class="col">
                                        <label for="dateRange" class="form-label" >Date range</label>
                                        <select class="form-control" name="range">
                                                <option selected disabled>{{ $range }}</option>
                                                <option selected>Select range</option>
                                                <option>Last 30 days</option>
                                                <option >Last 15 days</option>
                                                <option >Last 7 days</option>
                                        </select>
                                    </div>       
                                    <div class="col">
                                        <label for="dateFrom" class="form-label">From</label>
                                        <input type="date" name="from" value="{{ $startDate }}" class="form-control" >
                                    </div>
                                    <div class="col">
                                        <label for="dateTo" class="form-label">To</label>
                                        <input type="date" name="to" value="{{ $endDate }}" class="form-control" >
                                    </div>
                                    <div class="col">
                                        <label for="dateRange" class="form-label">Group by data</label>
                                        <select class="form-control" name="type">
                                                <option selected disabled >{{ $type }}</option>
                                                <option>Day</option>
                                                <option >Week</option>
                                                <option >Month</option>

                                        </select>
                                    </div> 
                                </div>
                            </div></br></br>
                            <h5>Filters</h5>
                            <div class="row">
                                <div class="col">
                                <label for="fullfillment" class="form-label">Store/catelog</label>
                                    <select class="form-control">
                                            <option selected>Store/catelog</option>
                                    </select>
                                </div>
                                <div class="col">
                                <label for="fullfillment" class="form-label">Category</label>
                                    <select class="form-control" name="category"> 
                                    <option selected>{{ $category }}</option>    
                                    <option selected>Select Category</option>
                                    @foreach($category1 as $cat)
                                        <option>{{$cat->ProductType}}</option>
                                    @endforeach
                                    </select>
                                </div> 
                                <div class="col">
                                    <label for="fullfillment" class="form-label">Sources</label>
                                    <select id="sourceSelect" name="source" class="form-control ">
                                            <option value="" selected>Select Source</option>
                                            @foreach($sources as $source)
                                                <option value="{{ $source->source }}" {{ isset($sourceName) && $sourceName === $source->source ? 'selected' : '' }}>{{ $source->source_name }}</option>
                                            @endforeach
                                        </select>
                                </div> 
                                <div class="col">
                                    <label for="custype" class="form-label">Other Sources</label>
                                    <select id="subSourceSelect" name="sub_source" class="form-control ">
                                            <option value="" selected>Select Sub-Source</option>
                                            @foreach($subSources as $subSource)
                                                <option value="{{ $subSource->sub_source }}" {{ isset($subSourceName) && $subSourceName === $subSource->sub_source ? 'selected' : '' }}>{{ $subSource->sub_name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div></br>
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </form>
                        
                    </div></br></br>

                        <div style="margin-left:40px">
                            @include('test1');
                        </div></br>
                    
                    <!-- <div id="result" style="margin-left:20px"></div>

                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    
                    <script>
                            function submitForm() {
                                
                                $.ajax({
                                    url: '{{ route("formResult") }}',
                                    type: 'POST',
                                    data: $('#myForm').serialize(),
                                    success: function(response) {
                                        
                                        $('#result').html(response.view);
                                        $('#result1').html(response.view1);

                                            if (!chartInitialized) {
                                                console.log('New Chart Data:', response.newChartData);
                                                initializeChart();
                                            } else {
                                            

                                            // Update the chart with new data
                                            updateChart(response.newChartData);
                                        }
                        },
                                    error: function(xhr) {
                                        console.log(xhr.responseText);
                                    }
                                });
                            }
                    </script> -->

                    <!-- Content Row -->

                    <!-- <div style="margin-left:20px"><h3>Total Revenue</h3></div>
                    <div style="margin-top:10px;margin-left:20px"><h1>9,925.35</h1></div> -->

                    <!-- <div class="row"> -->


                    <!-- <canvas id="salesLineChart"></canvas> -->
                        <!-- Area Chart -->
                        <!-- <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4"> -->
                                <!-- Card Header - Dropdown -->
                                <!-- <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div> -->
                                <!-- </div> -->

                               

                                <!-- Card Body -->
                                <!-- <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div> </br></br> -->

                                
                            <!-- </div>

                    <div> -->
                        <!-- @yield('content') -->
                        
                    <!-- </div> -->
                           
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

{{-- source subSource --}}
 
 <script>
    $(document).ready(function () {
        
        var sourceName = '{{ $sourceName ?? '' }}';
        $('#sourceSelect').val(sourceName);

        
        var subSourceName = '{{ $subSourceName ?? '' }}';
        $('#subSourceSelect').val(subSourceName);

   
        
        function updateSubSources(sourceId, selectedSubSource) {
            $.ajax({
                url: '/get-sub-sources/' + sourceId,
                type: 'GET',
                success: function (data) {
                    $('#subSourceSelect').empty();
                    $('#subSourceSelect').append('<option value="" selected>Select Sub-Source</option>');

                
                    $.each(data, function (key, subSource) {
                        $('#subSourceSelect').append('<option value="' + subSource.sub_name + '">' + subSource.name + '</option>');
                    });

                
                    $('#subSourceSelect').val(selectedSubSource || '');
                }
            });
        }

       
        updateSubSources($('#sourceSelect').val(), subSourceName);
       
        
        $('#sourceSelect').on('change', function () {
           
            var selectedSource = $(this).val();

           
            updateSubSources(selectedSource, '');

          
            $('#sourceSelect').val(selectedSource);
        });
    });
</script>


{{-- source subSource end--}}


<!-- js for chart -->
<!-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const orders = {!! json_encode($orders) !!};

    const dates = order.map(order => order.order_date);
    const amounts = orders.map(sale => order.order_total);

    const ctx = document.getElementById('salesLineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: ' Chart',
                borderColor: 'rgb(75, 192, 192)',
                data: amounts,
                fill: false,
            }],
        },
    });
});
</script> -->
<!-- js for chart -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>