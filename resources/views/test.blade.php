<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var x_labels = <?php echo json_encode($x_labels); ?>;
            var x_values = <?php echo json_encode($x_values); ?>;

            console.log('x_labels:', x_labels);
            console.log('x_values:', x_values);

            // Uncomment the next line to check the expected structure of your data
            // debugger;

            var data = google.visualization.arrayToDataTable(getChartData(x_labels, x_values));

            var options = {
                title: 'Order Performance',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }

        function getChartData(labels, values) {
            var chartData = [['Year', ...labels]];

            for (var label in values) {
                if (values.hasOwnProperty(label)) {
                    var row = [label, ...values[label]];
                    chartData.push(row);
                }
            }

            return chartData;
        }
    </script>
</head>
<body>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
</body>
</html>

<canvas id="salesChart" width="800" height="400"></canvas>

    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesData = {
            labels: @json($label_1_month),
            datasets: [{
                label: 'Sales in the last month',
                data: @json($data_1_month),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        };

        // var salesChart = new Chart(ctx, {
        //     type: 'line',
        //     data: salesData,
        //     options: {
        //         responsive: true,
        //         scales: {
        //             x: {
        //                 type: 'time',
        //                 time: {
        //                     unit: 'day',
        //                     displayFormats: {
        //                         day: 'MMM D'
        //                     }
        //                 }
        //             },
        //             y: {
        //                 beginAtZero: true
        //             }
        //             </script>