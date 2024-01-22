<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cdbootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cdbootstrap/css/cdb.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/cdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/9d1d9a82d2.js" crossorigin="anonymous"></script>

    <title>How to create bootstrap charts using bootstrap 5 and Contrast</title>

    <style>
        .chart-container {
            width: 50%;
            height: 50%;
            margin: auto;
        }
    </style>
  </head>

  <body>
    <div class="card chart-container">
    <canvas id="chart"></canvas>
</div>
  </body>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
  <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="../contrast-bootstrap-pro/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../contrast-bootstrap-pro/css/cdb.css" />
  <script src="../contrast-bootstrap-pro/js/cdb.js"></script>
  <script src="../contrast-bootstrap-pro/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/9d1d9a82d2.js" crossorigin="anonymous"></script>

  <title>How to create bootstrap charts using bootstrap 5</title>
</head>
<style>
  .chart-container {
    width: 50%;
    height: 50%;
    margin: auto;
  }
</style>

<body>
  <div class="card chart-container">
    <canvas id="chart"></canvas>
  </div>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js">
</script>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="../contrast-bootstrap-pro/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../contrast-bootstrap-pro/css/cdb.css" />
  <script src="../contrast-bootstrap-pro/js/cdb.js"></script>
  <script src="../contrast-bootstrap-pro/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/9d1d9a82d2.js" crossorigin="anonymous"></script>

  <title>How to create bootstrap charts using bootstrap 5</title>
</head>
<style>
  .chart-container {
    width: 50%;
    height: 50%;
    margin: auto;
  }
</style>

<body>
  <div class="card chart-container">
    <canvas id="chart"></canvas>
  </div>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<script>
      const ctx = document.getElementById("chart").getContext('2d');
      const myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["sunday", "monday", "tuesday",
          "wednesday", "thursday", "friday", "saturday"],
          datasets: [{
            label: 'Last week',
            backgroundColor: 'rgba(161, 198, 247, 1)',
            borderColor: 'rgb(47, 128, 237)',
            data: [3000, 4000, 2000, 5000, 8000, 9000, 2000],
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
              }
            }]
          }
        },
      });
</script>

</html>

</html>
</html>