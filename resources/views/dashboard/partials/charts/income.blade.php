<div class="bg-white bg-opacity-90 rounded py-8 px-8">

    <div class="flex items-center justify-between mb-8">
        <div class="text-2xl font-bold tracking-tighter">
            Revenue par mois
        </div>
        <div class="">
            <button class="py-2 px-4 rounded cursor-pointer hover:bg-white">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <canvas id="myChart" class="w-full"></canvas>
</div>


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
            labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            datasets: [{
                label: '# Income 2019',
                borderWidth: 1,
                borderRadius: 20,
                lineTension:0.1,
                barPercentage: 0.5,
                categoryPercentage: .25,
                data: [12450, 9650, 19480, 5040, 12000, 25400, 19450, 19650, 29480, 7040, 17000, 21400],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.9)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)'
                ],
            },
            {
                label: '# Income 2020',
                borderWidth: 1,
                borderRadius: 20,
                lineTension:0.1,
                barPercentage: 0.5,
                categoryPercentage: .25,
                data: [13450, 11650, 13480, 7040, 18000, 16400, 9450, 29650, 15480, 9040, 16000, 19400],
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
