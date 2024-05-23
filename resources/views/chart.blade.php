<!DOCTYPE html>
<html>

<head>
    <title>Laravel Charts</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div>
        <h1>Wyświetlenia dla produktu</h1>
        <canvas id="productsChart"></canvas>
    </div>

    <script>
        var products = @json($products);
        var labels = products.map(function(product) {
            return product.name;
        });
        var data = products.map(function(product) {
            return product.views;
        });
        var ctx = document.getElementById('productsChart').getContext('2d');
        var productsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Liczba wyświetleń',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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
