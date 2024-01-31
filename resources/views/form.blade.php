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
                    <h2>Active Date Range: 23 December 2023 - 21 January 2024</h2>
                    <h5>Date range and Grouping</h5>
                    <div class="row">
                        <form action="{{ route('formResult') }}" id="myForm" method = "get" class="form-control">
                            @csrf
                            <div class="row">
                                <div class="col">
                                        <label for="dateRange" class="form-label" >Date range</label>
                                        <select class="form-control" name="range">
                                                <option selected>{{ $range }}</option>
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
                                                <option selected >{{ $type }}</option>
                                                <option selected>Day</option>
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

</body>
</html>
