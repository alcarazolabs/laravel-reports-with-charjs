<html>

   <head>
       <title>Purchases Reports</title>
        <!-- Styles compilados de Bootstrap-->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css" />
        
        <style type="text/css">
            .container{
                padding:10px;
            }
          
        </style>
    </head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Total de Compras de cada Comprador</h4>
            <hr>
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <th>Comprador Nombres</th>
                    <th>Total S/.</th>
                </thead>

                <tbody>
                @foreach($totalBuyerPurchases as $totalBuyerPurchase)
                    <tr>
                        <td>{{$totalBuyerPurchase->buyerName}}</td>
                        <td>{{$totalBuyerPurchase->purchaseTotal}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="row">
      <div class="col-md-8">
         <canvas id="myChart1"></canvas>
      </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Total de Compras de cada Departamento</h4>
            <hr>
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <th>Departamento Nombre</th>
                    <th>Total S/.</th>
                </thead>

                <tbody>
                @foreach($departmentsPurchases as $departmentsPurchase)
                    <tr>
                        <td>{{$departmentsPurchase->departmentName}}</td>
                        <td>{{$departmentsPurchase->purchasesTotal}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
      <div class="col-md-8">
         <canvas id="myChart2"></canvas>
      </div>
    </div>

</div>
      <!-- Bootstrap JS, jquery y popper compilado -->
      <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
     <script>
            var buyersNames = [];
            var buyersPurchasesTotal = [];

            var departmentsNames = [];
            var totalDepartments = [];
            @foreach ($totalBuyerPurchases as $totalBuyerPurchase)
                 buyersNames.push('{{$totalBuyerPurchase->buyerName}}');
                 buyersPurchasesTotal.push('{{$totalBuyerPurchase->purchaseTotal}}');
            @endforeach

            @foreach ($departmentsPurchases as $departmentsPurchase)
                departmentsNames.push('{{$departmentsPurchase->departmentName}}');
                totalDepartments.push('{{$departmentsPurchase->purchasesTotal}}');
            @endforeach
           
           
var ctx = document.getElementById('myChart1').getContext('2d');
var ctx_1 = document.getElementById("myChart1");
ctx_1.height = 150;

var ctx2 = document.getElementById('myChart2').getContext('2d');
var ctx_2 = document.getElementById("myChart2");

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: buyersNames,
                datasets: [{
                    label: 'Cantidad total S/. de compras',
                    data: buyersPurchasesTotal,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        var myChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: departmentsNames,
                datasets: [{
                    label: 'Cantidad compras totales S/.',
                    data: totalDepartments,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
</body>

</html>