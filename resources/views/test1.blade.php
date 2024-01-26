<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Line Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        console.log('Script Start');
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('salesChart').getContext('2d');
            
            var salesData = {
                labels: @json(array_keys($currentYearData->merge($previousYearData)->toArray())),
                datasets: [
                    {
                        label: 'Current Year',
                        data: @json($currentYearData->values()),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Previous Year',
                        data: @json($previousYearData->values()),
                        borderColor: 'rgba(192, 75, 75, 1)',
                        borderWidth: 2,
                        fill: false
                    }
                ]
            };

            var salesChart = new Chart(ctx, {
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
                                unit: 'day',
                                unitStepSize: 1,
                                displayFormats: {
                                    day: 'MMM D'
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
        });
        console.log('Current Year Data:', @json($currentYearData->values()));
    console.log('Previous Year Data:', @json($previousYearData->values()));

        console.log('Script End');
    </script>
</head>
<body>

<canvas id="salesChart" width="800" height="400"></canvas>

</body>
</html>
