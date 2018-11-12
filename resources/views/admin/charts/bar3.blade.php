<canvas id="my_chart3" ></canvas>
<script>
    $.get('get_chart_data',function (data, status) {
        var ctx = document.getElementById("my_chart3").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    "普通用户",
                    "VIP用户",
                    "代理商",
                    "合作商",
                    "合伙人"
                ],
                datasets: [{
                    label: '# of Votes',
                    data: data,
                    backgroundColor: [
                        window.chartColors.red,
                        window.chartColors.blue,
                        window.chartColors.yellow,
                        window.chartColors.green,
                        window.chartColors.purple,
                        window.chartColors.orange
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
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
                responsive: true
            }
        });
    });
    window.chartColors = {
        red: 'rgba(255, 99, 132, 0.2)',
        orange: 'rgba(54, 162, 235, 0.2)',
        yellow: 'rgba(255, 205, 86,0.2)',
        green: 'rgba(75, 192, 192,0.2)',
        blue: 'rgba(54, 162, 235,0.2)',
        purple: 'rgba(153, 102, 255,0.2)',
        grey: 'rgba(201, 203, 207,0.2)'
    };

</script>

