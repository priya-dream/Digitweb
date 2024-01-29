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
                        borderWidth: 3,
                        fill: false
                    },
                    {
                        label: 'Previous Year',
                        data: @json($previousYearData->values()),
                        borderColor: 'rgba(192, 75, 75, 1)',
                        borderWidth: 3,
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


</body>
</html>
