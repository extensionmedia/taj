<div class="bg-white bg-opacity-80 rounded">
    <canvas id="myChart" class="w-full py-2 px-4"></canvas>
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var colors =   ` 'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                `;
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                borderWidth: 1,
                borderRadius: 20,
                lineTension:0.1,
                barPercentage: 0.5,
                categoryPercentage: .25,
                data: [12, 19, 3, 5, 12, 13],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.9)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)'
                ],
            },
            {
                label: '# of Votes',
                borderWidth: 1,
                borderRadius: 20,
                lineTension:0.1,
                barPercentage: 0.5,
                categoryPercentage: .25,
                data: [19, 35, 9, 7, 2, 3],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.9)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)'
                ],
            }
            ]
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
    
</div>