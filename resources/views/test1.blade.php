<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Line Chart</title>
    </head>
    <body>
        <h2>Chart</h2>
                <canvas id="salesChart" width="800" height="400"></canvas>
            
        
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
    <script>
        // console.log('Script Start');
        var chartInitialized = false;
        var salesChart;

        function initializeChart() {
            var ctx = document.getElementById('salesChart').getContext('2d');
            console.log('Canvas Element:', ctx);

            var ctx = document.getElementById('salesChart').getContext('2d');
            console.log('Canvas Element:', ctx);

            var unit = 'day';
            var unitStepSize = 1;

            var diff = @json($diff);
            var type = @json($type);

            if ( type === "Day") {
                unit = 'day';
                unitStepSize = 1;
            }

            if (type === "Week") {
                unit = 'week';
                unitStepSize = Math.ceil(diff / 7);
            }
            if (type === "Month") {
                unit = 'month';
                unitStepSize = Math.ceil(diff / 30);
            }
            
            var salesData = {
                labels: unit === 'week' ? @json($weekLabels) : unit === 'month' ? @json($monthLabels) : @json(array_keys($currentYearData->merge($previousYearData)->toArray())),
                datasets: [
                    {
                        label: 'Current Year',
                        data: @json($currentYearData->values()),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 4,
                        fill: false
                    },
                    {
                        label: 'Previous Year',
                        data: @json($previousYearData->values()),
                        borderColor: 'rgba(153, 139, 230, 1)',
                        borderWidth: 4,
                        fill: false
                    }
                ]
            };

           

              salesChart = new Chart(ctx, {
                type: 'line',
                data: salesData,
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Sales Chart'
                        }
                    },
                    scales: {
                        x: [{
                            type: 'time',
                            time: {
                                parser: 'YYYY-MM-DD',
                                tooltipFormat: 'MMM D',
                                unit: unit,
                                unitStepSize: unitStepSize,
                                displayFormats: {
                                    day: 'MMM D',
                                    week: 'W',
                                    month: 'M'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Date Range'
                            }
                        }],
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Sales'
                            }
                        }
                    }
                }
            });

            chartInitialized = true;
        }

        function updateChart(newData) {
            // Update the chart data
            salesChart.data = newData;

            // Update the chart
            salesChart.update();
        }
        document.addEventListener('DOMContentLoaded', function () {
            initializeChart();
            
            
        });
//         console.log('Current Year Data:', @json($currentYearData->values()));
//     console.log('Previous Year Data:', @json($previousYearData->values()));
//     console.log('Labels:', @json(array_keys($currentYearData->merge($previousYearData)->toArray())));
// console.log('Current Year Data:', @json($currentYearData->values()));
// console.log('Previous Year Data:', @json($previousYearData->values()));

//         console.log('Script End');
    </script>
</br></br>
<h2>Categories Performance</h2></br>
        <table class="table table-striped" style="margin-left:30px">
        
            <tr>
                <th scope="col">Category Name</th>
                <th scope="col">No of Products</th>
                <th scope="col">Revenue</th>
                <th scope="col">Revenue Trend</th>
                <th scope="col">Unitsold</th>
                <th scope="col">Unitsold Trend</th>
            </tr> 
            @foreach($result as $res)
                <tr>
                    <td>{{$res->category_name}} </td>
                    <td>{{$res->no_of_products}}</td>
                    <td>{{$res->revenue}}</td>
                    <td>{{$res->revenue_trend_percentage}} </td>
                    <td>{{$res->qty}}</td>
                    <td>{{$res->qty_trend_percentage}} </td>
                </tr>
            @endforeach
        
        
            
        </table></br>
</body>
</html>