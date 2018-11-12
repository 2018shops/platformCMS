<canvas id="my_chart" ></canvas>
<script>
    $.get('get_chart_data',function (data, status) {
        var ctx = document.getElementById("my_chart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    "会员用户",
                    "VIP用户",
                    "总代理",
                    "合伙人",
                    "区代",
                    "市代",
                    "省代",
                    "招商经理",
                    "销售经理",
                    "市场总监"
                ],
                datasets: [{
                    label: '# of Votes',
                    data: data,
                    backgroundColor: [
                        window.chartColors.red,
                        window.chartColors.orange,
                        window.chartColors.yellow,
                        window.chartColors.green,
                        window.chartColors.blue,
                        window.chartColors.indigo,
                        window.chartColors.purple,
                        window.chartColors.pink,
                        window.chartColors.cyan,
                        window.chartColors.gray

                    ],
                    borderColor: [
                        'rgba(255,0,0,1)',
                        'rgba(255,165,0,1)',
                        'rgba(255,255,0,1)',
                        'rgba(0,128,0,1)',
                        'rgba(0,0,255,1)',
                        'rgba(75,0,130,1)',
                        'rgba(128,0,128,1)',
                        'rgba(255,192,203,1)',
                        'rgba(0,255,255,1)',
                        'rgba(128,128,128,1)'
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
        red: 'rgba(255,0,0,0.2)',
        orange: 'rgba(255,165,0,0.2)',
        yellow: 'rgba(255,255,0,0.2)',
        green: 'rgba(0,128,0,0.2)',
        blue: 'rgba(0,0,255,0.2)',
        indigo: 'rgba(75,0,130,0.2)',
        purple: 'rgba(128,0,128,0.2)',
        pink: 'rgba(255,192,203,0.2)',
        cyan: 'rgba(0,255,255,0.2)',
        gray: 'rgba(128,128,128,0.2)',
    };

</script>

